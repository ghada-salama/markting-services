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
use AppBundle\Entity\header;
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
use AppBundle\Form\HeaderType;



class HeaderController extends Controller
{
    use ApiResponseTrait;


    /**
     * @param Request $request
     * @Annotations\Get("api/header/list",name="list_header")
     * @Annotations\View(serializerGroups={
     *   "show_header"
     * })
     */
    public function listHeader()
    {
        
        $res['data']=$this->getDoctrine()->getRepository('AppBundle:header')->getAll();
        return $res;
    }

       /**
     * @param Request $request
     * @Annotations\Get("api/header/autoCompletelist",name="autoCompletelist_header")
     * @Annotations\View(serializerGroups={
     *   "show_header"
     * })
     */
    public function autoCompletelist(Request $request)
    {
       $key=$request->get('q');
        $res['data']=$this->getDoctrine()->getRepository('AppBundle:header')->getAllByName($key);
        return $res;
    }



    /**
     * @param Request $request
     * @Annotations\Post("api/header/add",name="add_header")
     */
    public function addHeader(Request $request)
    {
       
         
        $data=$request->getContent();
        $data = json_decode($data);
        //dump($request->request->all());die();
        
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $header = new header();
        $form = $this->createForm(HeaderType::class,$header);
        $form->submit($request->request->all());

        if ($form->isValid()) {

               // die("add header.....");
                $header->setName($data->name);
                if(!isset($data->enable))
                {
                    $header->setEnable(1);
                }else{
                    $header->setEnable($data->enable);
                }
                $header->setLastUpdatedBy($user);
                $header->setLastUpdatedAt(new \DateTime());
                $em->persist($header);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
         
      
   }

    /**
     * @param Request $request
     * @Annotations\Post("api/header/edit/{id}",name="edit_header")
     * @ParamConverter("header", class="AppBundle:header")
     */
    public function editHeader(Request $request,$id)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        //$header = new header();
        $header = $this->getDoctrine()->getRepository(header::class)->find($id);
        $form = $this->createForm(HeaderType::class,$header);
        $form->submit($request->request->all());

        if ($form->isValid()) {

               // die("add header.....");
                $header->setName($data->name);
                if(!isset($data->enable))
                {
                    $header->setEnable(1);
                }else{
                    $header->setEnable($data->enable);
                }
                $header->setLastUpdatedBy($user);
                $header->setLastUpdatedAt(new \DateTime());
                $em->persist($header);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
      
   }

    /**
     * @Route("/api/header/delete",name="delete_header")
     * @Annotations\View()
     * @Method({"Post"})
     */

    public function deleteHeader(Request $request)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $id=$data->id;

        $header=$this->getDoctrine()->getRepository('AppBundle:header')->find($id);
        $em=$this->getDoctrine()->getManager();
        $header->setFlag(1);
        $em->persist($header);
        $em->flush(); 
        return $this->apiResponse(null, 'success', 200);
    }

    /**
     * @param Request $request
     * @Annotations\Post("api/header/select",name="select_header")
     * @Annotations\View(serializerGroups={
     *   "show_activities"
     * })
     */
    public function selectHeader(Request $request)
    {
       // die("dfdfd");
          //die("select  theme");
         //get id
         $data=$request->getContent();
         $activityData = json_decode($data);
         $id=$activityData->activity_id;

        // dump($activityData);die();
         //theme info 
         $header_id=$activityData->header;
         //user info
         $user=$this->getUser();
        // dump($user);die();
         //$activityData=$getJson->data;
         $explodedId=explode('-',$id);
        // dump($explodedId); die("dfdfdf");
        //get activity or create 
        $client_id = $explodedId[0]; 
        $brand_id  = $explodedId[1];
        $year      = $explodedId[2];
        $month     = $explodedId[3];
        $half      = $explodedId[4];
 
        $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($client_id,$brand_id,$year,$month,$half);
        dump($activity); die("dfdfdf"); 
        $em = $this->getDoctrine()->getManager();
         //clear theme 
       if($header_id==null)
       {
         
        $activity->setHeader(null);
        $activity->setHeaderExtraInfo(null);
        $em->persist($activity);
        $em->flush();
        return $this->apiResponse(null, 'success', 200);

       } 
       
        $header=$this->getDoctrine()->getRepository('AppBundle:header')->find($activityData->header);
       
         if($activity&&$header){

                //if activity found update theme
                $activity->setHeader($header);
                $activity->setHeaderExtraInfo($activityData->extraInfoHeader);
                // $activity->setThemelastUpdateBy($user);
                // $activity->setThemelastUpdateAt(new \DateTime());

                $em->persist($activity);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
         }else
         {
             //else create new activity and add theme
                $client=$this->getDoctrine()->getRepository('AppBundle:Client')->find($client_id);
                $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($brand_id);
                $activity = new Activity();
                $activity->setClient($client);
                $activity->setBrand($brand);
                $activity->setWYear($year);
                $activity->setWMonth($month);
                $activity->setWHalf($half);
                $activity->setHeader($header);
                $activity->setThemeExtraInfo($activityData->extraInfoHeader);
                // $activity->setThemelastUpdateBy($user);
                // $activity->setThemelastUpdateAt(new \DateTime());
                $em->persist($activity);
                $em->flush();
           
           // $form->submit($request->request->all());
           return $this->apiResponse(null, 'success', 200);
         }
      
   }


 
    
}
