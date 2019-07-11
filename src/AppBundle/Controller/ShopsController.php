<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use AppBundle\Service\Validate;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Translation\Translator;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Client;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Activity;
use AppBundle\Entity\shops;
use AppBundle\Entity\DefaultShopValue;

class ShopsController  extends FOSRestController implements ClassResourceInterface 
{


    use ApiResponseTrait;

  /**
    * 
    * @Annotations\Post("api/shops",name="get_shops")
    * @Annotations\View(serializerGroups={
    *   "shops_component"
    * })
    */

    public function getGrideAction(Request $request)
    {
        
        $data=$request->getContent();
        $getJson = json_decode($data);

        $client_id=$getJson->id;

        
        $translated_titles=[];
        $translated_monthes=[];
        $translated_monthes_name=[];
        $result=[];

        //set filters 
        //set defult values
        //TODO:get filtters form user setting
        $filters['year']=$request->get('year')?$getJson->year:date("Y"); 
        //$filters['rows']=$mode;
        $filters['start_month']=$request->get('start_month')?$request->get('start_month'):1;
        $filters['number_month']=$request->get('number_month')?$request->get('number_month'):12;
       
        //translate title  if key true
        // foreach($titles as $key=>$flage)
        // {
        //     if($flage)
        //     {
        //         $translated_titles[$key]=$this->get('translator')->trans($key);
                        
        //     }
        // }
            //translate month
            $end_month=($filters['start_month']+$filters['number_month'])-1;
            for ($month=$filters['start_month']; $month <= $end_month ; $month++) 
            {
                 $monthNumber=$month;
                if($month >12)
                {
                  // echo gettype($month);die; 
                    $monthNumber=($month-12);
                }
                $translated_monthes[$monthNumber]=$this->get('translator')->trans($monthNumber);
                $translated_monthes_name[]=$this->get('translator')->trans($monthNumber);
            }
            
          
        //translate half months
        // foreach ($half_months as $key => $value) 
        // {

        //     $filters['half_months'][$key]=$this->get('translator')->trans($key);
        // }
    
    
        $filters['titles']=$translated_titles;
        //$filters['translated_monthes']=$translated_monthes;
        $filters['translated_monthes_name']=$translated_monthes_name;
        $filters['translated_monthes']=$this->getTraslatedMonthsRang($filters);//$translated_monthes;
        //dump($filters['translated_monthes']);die;
        //die("sdsd");
        $user=$this->getUser();
        $result=$this->getDoctrine()->getRepository('AppBundle:Activity')->getShopsRows($client_id,$filters,$user);
        return $result; 
    }

     /**
    * 
    * @Annotations\Post("api/shops/edit",name="edit_shops")
    * @Annotations\View(serializerGroups={
    *   "shops_component"
    * })
    */

    public function getEditAction(Request $request)
    {
            //get id
            // $data=$request->getContent();
            // $activityData = json_decode($data);
            // $id=$activityData->activity_id;

            // if($this->updateShops($id,$activityData))
            // {
            //     return $this->apiResponse(null,null ,200,$message='success');    
            // }
            // return $this->apiResponse(null,"null" ,400,$message='faild');

            $data=$request->getContent();
            $activityData = json_decode($data);
           foreach ($activityData as $activity) {
   
               $id=$activity->activity_id;
               $this->updateShops($id,$activity);
           }
           return $this->apiResponse(null,null ,200,$message='success');
           

    }


    public function updateShops($id,$activityData)
    {
        
             $explodedId = explode('-',$id);
             $client_id = $explodedId[0]; 
             $brand_id  = $explodedId[1];
             $year      = $explodedId[2];
             $month     = $explodedId[3];
             $half      = $explodedId[4];
         
             //get activity or create new activity 
             $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getOneActivity($client_id,$brand_id,$year,$month,$half);
            //dump($activity); die("sdsds");
            //dump($activity);die();
             if(!$activity)
             {
                
                // die("no activity ...");
                 $em = $this->getDoctrine()->getManager();
                 $client = $this->getDoctrine()->getRepository(Client::class)->find($client_id);
                 $brand = $this->getDoctrine()->getRepository(Brand::class)->find($brand_id);
                 $activity = new Activity();
                 $activity->setClient($client);
                 $activity->setBrand($brand);
                 $activity->setWYear($year);
                 $activity->setWMonth($month);
                 $activity->setWHalf($half);
                 $em->persist($activity);
                 $em->flush();
                 //return $activity;
             }
             foreach ($activityData as $key => $value) 
             {
             //print_r($value);
                 if($key!='activity_id')
                 {
 
                         //update hq shops or gpv shops
                         if($key=='shopsHqValue')
                         {
 
                            // $explodedId = explode("_",$value->isSub);
                             //$prefix     =  $explodedId[0];
                             $this->updateActivityShops($activity,'hq',$brand_id,$value);
 
                         }else if($key=='shopsGpvValue')
                         {
                            $this->updateActivityShops($activity,'gpv',$brand_id,$value);

                         }
                     
 
                 }
  
         
            }
            return true;
    }


    public function updateActivityShops($activity,$prefix,$brand_id,$value)
    {
         $user=$this->getUser();
         $groups=$user->getGroups()->toArray();
         $hq=false;
         $gpv=false;
         foreach ($groups as  $group)
        {  
                if(((in_array('ROLE_HQ_ADMIN',$group->getRoles())||in_array('ROLE_SUPER_ADMIN',$group->getRoles()))))
                {
                    $hq=true;
                }
                if(((in_array('ROLE_GPV_ADMIN',$group->getRoles())||in_array('ROLE_SUPER_ADMIN',$group->getRoles()))  ))//&& $key==='shopsGpvValue'
                {
                    $gpv=true;
                }
            
        }
         $shops=$this->getDoctrine()->getRepository('AppBundle:shops')->getMyShops((int)$brand_id,$activity->getId());
         if(!$shops)
         {
             $brand = $this->getDoctrine()->getRepository(Brand::class)->find($brand_id);
             $shops = new shops();
             $shops->setBrand($brand);
             $shops->setActivity($activity);
         }
         if($prefix=='hq' && $hq)
         {
             $shops->setShopsHqValue($value);
         }else if($prefix=='gpv' && $gpv)
         {
             $shops->setShopsGpvValue($value);
         }
         $em=$this->getDoctrine()->getManager();
         $em->persist($shops);
         $em->flush();
         return true;
       
    }

    /**
    * 
    * @Annotations\Post("api/shops/getdefult",name="get_defult_shops")
    * @Annotations\View(serializerGroups={
    *   "shops_component"
    * })
    */

    public function getDefultValueShops(Request $request)
    {
        $data=$request->getContent();
        $activityData = json_decode($data);
        $id=$activityData->activity_id;
        $header=$activityData->header;

        
        $explodedId = explode('-',$id);
        $client_id = $explodedId[0]; 
        $brand_id  = $explodedId[1];
        $year      = $explodedId[2];
        $month     = $explodedId[3];
        $half      = $explodedId[4];

        $shops=$this->getDoctrine()->getRepository('AppBundle:DefaultShopValue')->getDefultValue($client_id,$brand_id,$header);
       // dump($shops);die();
        if($shops)
        {
            return $this->apiResponse($shops, null, 200,'success');
            
        }
        return $this->apiResponse(null, 'success', 200,"no defult value");

    }



   /*******************************************     defaultshopvalue    *******************************************************/ 
   
   


    /**
    * 
    * @Annotations\Post("/api/defaultshopvalue/add",name="create_defaultshopvalue")
    */
    public function createDefaultshopvalue(Request $request)
    {
        $data=$request->getContent();
        $jsonDecode=json_decode($data);
   
        
          $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($jsonDecode->brand);
          if(!$brand)
          {
            return $this->apiResponse(null, 'error', 400,"brand not found");  
          }
          $client=$this->getDoctrine()->getRepository('AppBundle:Client')->find($jsonDecode->client);
          if(!$client)
          {
            return $this->apiResponse(null, 'error', 400,"client not found");  
          }
          $header=$this->getDoctrine()->getRepository('AppBundle:header')->find($jsonDecode->header);
          if(!$header)
          {
            return $this->apiResponse(null, 'error', 400,"header not found");  
          }
            
        $defaultShopValue = new DefaultShopValue();
        $defaultShopValue->setBrand($brand);
        $defaultShopValue->setClient($client);
        $defaultShopValue->setHeader($header);
        $defaultShopValue->setShopsHQ($jsonDecode->shopshq);
        $defaultShopValue->setShopsGPV($jsonDecode->shopsgpv);
        
        

        // $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
       // $client=$serializer->deserialize($data,'AppBundle\Entity\Client','json');
        
        $em=$this->getDoctrine()->getManager();
        $em->persist($defaultShopValue);
        $em->flush();

        //TO DO json return
        return $this->apiResponse(null, null, 200,'success');
            
       
    }
    


 /**
    * 
    * @Annotations\Post("/api/defaultshopvalue/{DefaultShopValue}/update",name="edit_defaultshopvalue")
      * @ParamConverter("DefaultShopValue", class="AppBundle:DefaultShopValue")
    * @Annotations\View(serializerGroups={
    *   "defult_shops_component"
    * })
    */
    public function editDefaultshopvalue(Request $request,$DefaultShopValue)
    {
        //die("ada");
        $data=$request->getContent();
        $jsonDecode=json_decode($data);
   
       // return $jsonDecode->brand->id;
          $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($jsonDecode->brand->id);
          //dump($brand);die;
          $client=$this->getDoctrine()->getRepository('AppBundle:Client')->find($jsonDecode->client->id);
          $header=$this->getDoctrine()->getRepository('AppBundle:header')->find($jsonDecode->header->id);
            
      //  $defaultShopValue = $this->getDoctrine()->getRepository('AppBundle:Brand')->find($jsonDecode->brand->id);
      // return $brand;
        $DefaultShopValue->setBrand($brand);
        $DefaultShopValue->setClient($client);
        $DefaultShopValue->setHeader($header);
        $DefaultShopValue->setShopsHQ($jsonDecode->shopshq);
        $DefaultShopValue->setShopsGPV($jsonDecode->shopsgpv);
        
        

        // $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
       // $client=$serializer->deserialize($data,'AppBundle\Entity\Client','json');
        
        $em=$this->getDoctrine()->getManager();
        $em->persist($DefaultShopValue);
        $em->flush();

        //TO DO json return
        return $this->apiResponse(null, null, 200,'success');
            
       
    }
   

    
    /**
     *
     * @param Request $request
     * @Route("/api/defaultshopvalue/{DefaultShopValue}/show",name="show_defaultshopvalue")
     * @ParamConverter("DefaultShopValue", class="AppBundle:DefaultShopValue")
     * @Method({"POST"})
     */
    public function editshowDefaultshopvalue(Request $request,$defaultShopValue)
    {
        $data=$this->get('jms_serializer')->serialize($defaultShopValue,'json');
    
         return $this->apiResponse($data, null, 200,'success');
             
        
    }

 

    /**
    * 
    * @Annotations\Get("/api/defaultshopvalue/list",name="list_defaultshopvalue")
    * @Annotations\View(serializerGroups={
    *   "defult_shops_component"
    * })
    */
    public function listDefaultshopvalue()
    {
         $data=$this->getDoctrine()->getRepository('AppBundle:DefaultShopValue')->getAll();
         return $this->apiResponse($data, null, 200,'success');
             
        
    }



//TODO delete

    /**
    * 
    * @Annotations\Post("/api/defaultshopvalue/delete",name="delete_defaultshopvalue")
    * @Annotations\View(serializerGroups={
    *   "defult_shops_component"
    * })
    */
    public function deleteDefaultshopvalue(Request $request)
    {
            $data=$request->getContent();
            $data = json_decode($data);
            $id=$data->id;

           $row=$this->getDoctrine()->getRepository('AppBundle:DefaultShopValue')->find($id);
           if(!$row)
           {
             return $this->apiResponse(null, 'error', 400,"row not found");  
           }
            $em=$this->getDoctrine()->getManager();
            $row->setFlag(1);
            $em->persist($row);
            $em->flush(); 
       
        
        return $this->apiResponse(null, 'success', 200);
    }
    public function getTraslatedMonthsRang($filters)
    {
         $date=date("Y-m-d",mktime(0,0,0,$filters['start_month'],1,$filters['year']));     //2018-12-01
        // dump($date);die;
         $startdate= strtotime($date);                                                    //1543618800
         $enddata= strtotime($date. " +".$filters['number_month']."month");
         $rang=[];
        while ($startdate < $enddata)
        {

           $month=date('m', $startdate);
           $year=date('Y', $startdate);
           $month=date('m', $startdate);
           $monthNumber=(int)$month;
           if($month >12)
           {
               // echo gettype($month);die; 
               $monthNumber=(int)($month-12);
           }
           $monthNumber=$this->get('translator')->trans($monthNumber);
           
           $rang[] =['month'=>$monthNumber,'year'=>$year];
           $startdate = strtotime("+1 month", $startdate);

       }
    return $rang;
       
    }


  
}
