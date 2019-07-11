<?php

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Service\Validate;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Client;
use AppBundle\Entity\Activity;
use AppBundle\Entity\Nr;
use AppBundle\Entity\Fc;
use AppBundle\Entity\shops;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Translation\Translator;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Form\ActivityType;
use AppBundle\Entity\GeneralTheme;


class ActivityController extends Controller
{

    use ApiResponseTrait;

  
     /**
    * @param Request $request
    * @Annotations\Get("api/activity/addUpdate/{id}",name="get_edit_activity")
    * @Annotations\View(serializerGroups={
    *   "show_activities"
    * })
    */
    public function getAddAction(Request $request,$id)
    {
        //get activity data if found
        //  $data=$request->getContent();
        //  $activityData = json_decode($data);
        //  $id=$activityData->activity_id;
        

        $explodedId=explode('-',$id);
        //get activity or create 
        $client_id = $explodedId[0]; 
        
        $brand_id  = $explodedId[1];
        $year      = $explodedId[2];
        $month     = $explodedId[3];
        $half      = $explodedId[4];

        $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($client_id,$brand_id,$year,$month,$half);
      
        if(!$activity)
        {
            $client = $this->getDoctrine()->getRepository(Client::class)->find($client_id);
            $brand = $this->getDoctrine()->getRepository(Brand::class)->find($brand_id);

            if($client&&$brand)
            {
                //die("dsdscccccccccc");
                $em = $this->getDoctrine()->getManager();
                $activity = new Activity();
                $activity->setClient($client);
                $activity->setBrand($brand);
                $activity->setWYear($year);
                $activity->setWMonth($month);
                $activity->setWHalf($half);
                $em->persist($activity);
                $em->flush();
                return $activity;
                // dump($x);die();
                //$activity= $this->getDoctrine()->getManager()->getRepository('AppBundle:Activity')->find($em->getId());
                //return  $activity; 
            }
            //$em->getId();
            //return $em;
        }
        //dump($client_id);die();
        return $activity;

   }

   /**
     * @param Request $request
     * @Annotations\Post("api/activity/addUpdate",name="add_edit_activity")
     * @Annotations\View(serializerGroups={
     *   "show_activities"
     * })
     */
    public function createOrUpdateActivity(Request $request)
    {
         //die("sdsds");
         //get id
         $data=$request->getContent();
         $activityData = json_decode($data);
         $id=$activityData->activity_id;
        
        if($this->updateActivity($id,$activityData))
        {
            //return activity to set last updated at -last updated by 
            $explodedId = explode('-',$id);
            $client_id = $explodedId[0]; 
            $brand_id  = $explodedId[1];
            $year      = $explodedId[2];
            $month     = $explodedId[3];
            $half      = $explodedId[4];
        
            //get activity or create new activity 
            $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($client_id,$brand_id,$year,$month,$half);
            //dump($activity);die;

            // $data=[
            //     "lastUpdateBy"=>$activity->getLastUpdatedBy(),
            //     "lastUpdateAt"=>$activity->getLastUpdatedAt(),

            // ];
           // $activity->updatedBy=$activity->getLastUpdatedBy();
           // return $activity;
           //die("asasa");
            return $this->apiResponse($activity,null ,200,$message='success');    
        }
        return $this->apiResponse(null,"null" ,400,$message='faild');

    }
   /**
     * @param Request $request
     * @Annotations\Post("api/activity/addUpdateAll",name="add_edit_activities")
     * @Annotations\View(serializerGroups={
     *   "show_activities"
     * })
     */
    public function createOrUpdateActivities(Request $request)
    {
        
         //get id
         $data=$request->getContent();
         $activityData = json_decode($data);
        foreach ($activityData as $activity) 
        {
            $id=$activity->activity_id;
            //dump($id);die("sdsds");
            $this->updateActivity($id,$activity);
        }

        return $this->apiResponse(null,null ,200,$message='success');   
       
   }
   public function updateActivity($id,$activityData)
   {
       //die("sdsd");
            $explodedId = explode('-',$id);
            $client_id = $explodedId[0]; 
            $brand_id  = $explodedId[1];
            $year      = $explodedId[2];
            $month     = $explodedId[3];
            $half      = $explodedId[4];
        
            //get activity or create new activity 
           $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($client_id,$brand_id,$year,$month,$half);
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
                $user = $this->getUser();
                $activity->setLastUpdatedBy($user);
                //$date=date("Y-m-d H:i:s");//(new \DateTime())->format('Y-m-d H:i:s');
                //dump($date);die;
                $activity->setLastUpdatedAt(new \DateTime());

                $em->persist($activity);
                $em->flush();
                //return $activity;
            }
            foreach ($activityData as $key => $value) 
            {
            //print_r($value);
                if($key!='activity_id'||$key!='index')
                {

                        //update hq shops or gpv shops
                        if(($key=='hq_shops'||$key=='gpv_shops'))
                        {
                            if(is_object($value))
                            {
                                if($value->value=='')
                                {
                                    $value->value=null;
                                }
                                   // print_r( $value->value)  ;die("sds");
                                    // add or update brands shops
                                    $explodedId = explode("_",$value->isSub);
                                    $prefix     =  $explodedId[0];
                                     //check if total hq  shops less or equal client shops 
                                    $this->updateActivityShops($activity,$prefix,$brand_id,$value->value);
                               // }
                            }
                          
                             

                        }
                    // subbrand shops id
                        else if(is_object($value))
                        {
                            // die("dsds");
                            // add or update subbrand shops
                            $explodedId = explode("_",$value->isSub);
                            $prefix     =  $explodedId[0];
                            $brand_id   = $explodedId[1];
                            $this->updateActivityShops($activity,$prefix,$brand_id,$value->value);
                       
                        }
                        else if(!is_object($value))
                        {
                        $this->updateMyActivity($activity,$key,$value);
                            

                        }

                }
 
        
           }
           return true;
   }
   public function updateActivityShops($activity,$prefix,$brand_id,$value)
   {
       //
       
        $shops=$this->getDoctrine()->getRepository('AppBundle:shops')->getMyShops((int)$brand_id,$activity->getId());
        //dump($shops);die;
        if(!$shops)
        {

            $brand = $this->getDoctrine()->getRepository(Brand::class)->find($brand_id);
            $shops = new shops();
            $shops->setBrand($brand);
            $shops->setActivity($activity);
        }


        if($prefix=='hq')
        {

            //check if not null
            $shops->setShopsHqValue($value);
        }else
        {
            //check if total hq  shops less or equal client shops 
            $shops->setShopsGpvValue($value);
        }
        $em=$this->getDoctrine()->getManager();
        $em->persist($shops);
        $em->flush();
        return true;
      
   }

   public function updateMyActivity($activity,$attribute,$value)
   {
            $client=$activity->getClient();
            $brand=$activity->getBrand();
            $month=$activity->getWMonth();
            $half=$activity->getWHalf();
            $year=$activity->getWYear();
      
           $em = $this->getDoctrine()->getManager();
           //$brands=$this->getEntityManager()->getRepository('AppBundle:Activity')->find(activity);
           switch ($attribute) 
           {
               case 'header':
               $header=$this->getDoctrine()->getRepository('AppBundle:header')->find($value);
                $activity->setHeader($header);
                
               break;

               case 'theme':
               $gtheme=$this->getDoctrine()->getRepository('AppBundle:GeneralTheme')->getTheme($client->getId(),$year,$month,$half);
               
               if(!$gtheme)
               {
                $gtheme = new GeneralTheme();
               }
                $theme=$this->getDoctrine()->getRepository('AppBundle:Theme')->find($value);

                $gtheme->setThemeId($theme);
                $gtheme->setClientId($client);
                $gtheme->setWMonth($month);
                $gtheme->setWHalf($half);
                $gtheme->setWYear($year);
                $em->persist($gtheme);
                $em->flush();
                
               break;

               case 'gpv_shops':
                break;

               case 'offer':
               $activity->setOffer($value);
               
               break;

               case 'impact':
               $ms=$this->getDoctrine()->getRepository('AppBundle:msImpact')->find($value);
               $activity->setMsImpact($ms);
               break;

               case 'gama':
               $activity->setGama($value);
               break;

               case 'status':
               $activity->setStatus($value);

               break;

               case 'additional':
               $activity->setAdditional($value);

               break;

               case 'kpi':
               $activity->setKpi($value);
               break;

               case 'offe_quality':
               $of=$this->getDoctrine()->getRepository('AppBundle:OfferQuality')->find($value);
               $activity->setOfferQuality($of);
               break;

               case 'exposition':
               $ex=$this->getDoctrine()->getRepository('AppBundle:ExpositionQuality')->find($value);
               $activity->setExpositionQuality($ex);
               break;

               case 'nr':
               //client -brand -year month -nr
               $nr=$this->getDoctrine()->getRepository('AppBundle:Nr')->getNrRow($client->getId(),$brand->getId(),$year,$month);
               if(!$nr)
               {
                $nr = new Nr();
               }
               $nr->setNr($value);
               $nr->setClient($client);
               $nr->setBrand($brand);
               $nr->setWMonth($month);
               $nr->setWYear($year);
               $em->persist($nr);
               $em->flush();

               
               break;

               case 'fc':
               //client -brand -year month -fc
               $client=$activity->getClient();
               $brand=$activity->getBrand();
               $month=$activity->getWMonth();
               $year=$activity->getWYear();

               $fc=$this->getDoctrine()->getRepository('AppBundle:Fc')->getFcRow($client->getId(),$brand->getId(),$year,$month);
               if(!$fc)
               {
                $fc = new Fc();
               }
               $fc->setFc($value);
               $fc->setClient($client);
               $fc->setBrand($brand);
               $fc->setWMonth($month);
               $fc->setWYear($year);
               $em->persist($fc);
               $em->flush(); 
               break;      

               default:
              
               break;
           }
               $user = $this->getUser();
               $activity->setLastUpdatedBy($user);
               $activity->setLastUpdatedAt(new \DateTime());
               $em->persist($activity);
               $em->flush();
              // return true;
              

       
   }

   
   
    /**
    * @Annotations\Post("{_locale}/api/activity/show",name="show_activity")
    * @Annotations\View(serializerGroups={
    *   "show_activity"
    * })
    */
    public function showActivity(Request $request)
    {  //die("sdsds");
        //get id
        $data=$request->getContent();
        $getJson = json_decode($data);
        $id=$getJson->id;

        //explode id
        $explodedId=explode('-',$id);
       // dump($explodedId);die();
        $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($explodedId[0],$explodedId[1],$explodedId[2],$explodedId[3],$explodedId[4]);
        //dump($activity);die();
        if($activity){
            return $this->apiResponse($activity);
        }
      return $this->apiResponse(null, 'not found !', 404);

      

    }
    public function checkMaxShops($activity,$activityData)
    {

                       //check if total hq  shops less or equal client shops 
                            //get client shops
                            $clientShops=$activity->getClient()->getMaxShops();
                            //get total  brand and sub brands if found shops
                            
                            $totalShops = $this->getDoctrine()->getRepository(shops::class)->getMaxShops($brand_id,$activity->getId());
                        // die("vcv");
                            dump($totalShops);die;
                            if($clientShops > $totalShops)
                            {
                            return false;
                            }
       
    }


    /**
    * @Annotations\Post("/api/activityinfo/list",name="show_activity_list")
    * @Annotations\View(serializerGroups={
    *   "show_activities_list"
    * })
    
    */
    public function showActivityInfo(Request $request)
    {  
       
        $data=$request->getContent();
        $activities = json_decode($data);
        $list=[];
        //$ao = new ArrayObject();

        //loop 
        foreach ($activities as  $activitiy) 
        {
            $explodedId=explode('-',$activitiy->activity_id);
            $client_id = $explodedId[0]; 
            $brand_id  = $explodedId[1];
            $year      = $explodedId[2];
            $month     = $explodedId[3];
            $half      = $explodedId[4];

            //get activity or create new activity 
           //$activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($client_id,$brand_id,$year,$month,$half);
           $client=$this->getDoctrine()->getRepository('AppBundle:Client')->find($client_id);
           $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($brand_id);
           $obj=[
                'id'=>$activitiy->activity_id,
               'client'=>$client->getName(),
               'brand'=>$brand->getName(),
               'year'=>$year,
               'month'=>$month,
               'half'=>$half
            ];
           $list[]=$obj;

        }
       // return $list;
      return $this->apiResponse($list, 'success', 200);

      

    }

    


 
    
}
