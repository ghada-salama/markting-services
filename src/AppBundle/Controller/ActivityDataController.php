<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Service\Validate;
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
use AppBundle\Entity\OldActivity;
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
class ActivityDataController  extends FOSRestController implements ClassResourceInterface 
{


    use ApiResponseTrait;

    /**
    * 
    * @Annotations\Post("api/activity/all",name="getAllActivity")
    */

    public function getAll(Request $request)
    {

    

        $data=$this->getDoctrine()->getRepository('AppBundle:OldActivity')->getAll();
        //dump($data);die();
        foreach ($data as $key => $row) {

        if($row['flag']==null){
            //get activiy by year and month half and brand and year
           
            $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
           
           //dump($row['IDClient']);die();
            $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($row['IDClient']);
            // dump($client);die();
            $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->find($row['IDBrand']);
            //dump($brand);die();
            $em = $this->getDoctrine()->getManager();
            //insert only if exist client and brand 
            if($client && $brand)
            {
                //die("exist client and brand");
                    //create new acticity if not exist 
                    if(!$activity)
                    {
                       // die("new activty");
                        $activity=new Activity();
                        $activity->setClient($client);
                        $activity->setBrand($brand);
                        $activity->setWYear($row['WYear']);
                        $activity->setWMonth($row['WMonth']);
                        $activity->setWHalf($row['WHalf']);
                        $em->persist($activity);
                        $em->flush();
                    }

                     
                    //insert new row in shops if found brand id and shopsgpv activity id 
                    if($row['NShops']!=0)
                    {
                       // dump($activity);die();
                        $shops=new shops();
                        $shops->setShopsHqValue($row['NShops']);
                        $shops->setActivity($activity);
                        $shops->setBrand($brand);
                        $em->persist($shops);
                        $em->flush();
                    }
                    // dump($shops);die();
                    //loop on shops if exist 
                    for ($i=0; $i < 9; $i++) 
                    { 
                        //get subbrands
                       // dump($row['IDBrand']);die();
                        $subbrands=$this->getDoctrine()->getRepository('AppBundle:Brand')->getsubBrandsObj($row['IDBrand']);
                        
                        

                        if($row['NShops'.$i]!=0)
                        {
                            //
                            $col='nshops'.$i;
                            $subbrandName=$this->getDoctrine()->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);
                            //get id of sub brand by name
                            $subbrand=$this->getDoctrine()->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);
                            $shops=new shops();
                            $shops->setShopsHqValue($row['NShops'.$i]);
                            $shops->setActivity($activity);
                            $shops->setBrand($subbrand);
                            $em->persist($shops);
                            $em->flush();

                        }
                       # code...
                    }
                    //insert new shops activity id and get subbrand[shops prefix] 
            }
            //set flag =1 
            $oldDataRow=$this->getDoctrine()->getRepository('AppBundle:OldActivity')->getone($row['id']);
            //dump($row['id']);die();
           // dump($oldDataRow);die();
            $oldDataRow->setFlag(1);
            $em->persist($shops);
            $em->flush();
        }
    }
       
        return $this->apiResponse(null, 'success', 200);

    }

    /**
    * @Annotations\Get("api/activity/xx",name="xx")
    */

    public function getUpdateActivity()
    {
        //die("dfdf");
       // $doctrine = $this->getContainer()->get('doctrine');
       // $em = $doctrine->getEntityManager();
       $em = $this->getDoctrine()->getManager();

       $data= $this->getDoctrine()->getRepository('AppBundle:OldActivity')->getAll();  

         //dump($data);die();
         foreach ($data as $key => $row) 
         {

          // if($row['flag']==null){
               //get activiy by year and month half and brand and year
              
               $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivityById($row['id']);
            
              if($activity)
              { 
                  //dump($activity);die();
                  //update activity
                  $activity->setOffer($row['Oferta']);
                  $activity->setGama($row['Folleto']);
                  $activity->setAdditional($row['Adicional']);
                  $activity->setStatus($row['IDStatus']);
                  $activity->setKpi($row['KPIQuality']);
                  $oq=$this->getDoctrine()->getRepository('AppBundle:OfferQuality')->find($row['IDCalidadOf']);
                  if($oq)
                  {
                   
                    $activity->setExpositionQuality($oq);
                  }
                  
                  $eq=$this->getDoctrine()->getRepository('AppBundle:ExpositionQuality')->find($row['IDCalidadExp']);
                  if($eq)
                  {
                    $activity->setOfferQuality($eq);
                  }
                  $ms=$this->getDoctrine()->getRepository('AppBundle:msImpact')->find($row['IDRatio']);
                  if($ms)
                  {
                      //dump($ms);die();
                    $activity->setMsImpact($ms);
                  }
                  
                 
                 
                  


                  $em->persist($activity);
                  $em->flush();
                  //dump($activity);die();
                 // $output->writeln('<info>update activity ..</info>');

              }
            
    }
    return $this->apiResponse(null, 'success', 200);

    }

}
