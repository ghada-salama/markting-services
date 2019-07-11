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
use AppBundle\Entity\RealData;
use AppBundle\Entity\shops;
class RealDataController  extends FOSRestController implements ClassResourceInterface 
{


    use ApiResponseTrait;



    /**
    * 
    * @Annotations\Post("api/data/all",name="getAll")
    */

    // public function getAll(Request $request)
    // {
        
    //     set_time_limit(0);

    //     ini_set('memory_limit', '2048M');



    //     $data=$this->getDoctrine()->getRepository('AppBundle:RealData')->getAll();
    //     //dump($data);die();
    //     foreach ($data as $key => $row) {
            
    //      //dump($row['NShops'.$i]);die();
    //         //raeldata
    //         //get activiy by year and month half and brand and year
    //         //$activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
    //         $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
    //        // dump($activity);die();
    //        //dump($row['IDClient']);die();
    //         $client = $this->getDoctrine()->getRepository('AppBundle:Client')->find($row['IDClient']);
    //         // dump($client);die();
    //         $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->find($row['IDBrand']);
    //         //dump($brand);die();
    //         $em = $this->getDoctrine()->getManager();
    //         //insert only if exist client and brand 
    //         if($client && $brand)
    //         {
    //             //die("exist client and brand");
    //                 //create new acticity if not exist 
    //                 if(!$activity)
    //                 {
    //                    // die("new activty");
    //                     $activity=new Activity();
    //                     $activity->setClient($client);
    //                     $activity->setBrand($brand);
    //                     $activity->setWYear($row['WYear']);
    //                     $activity->setWMonth($row['WMonth']);
    //                     $activity->setWHalf($row['WHalf']);
    //                     $em->persist($activity);
    //                     $em->flush();
    //                 }

                     
    //                 //insert new row in shops if found brand id and shopsgpv activity id 
    //                 if($row['NShops']!=0)
    //                 {
    //                    // dump($activity);die();
    //                     $shops=new shops();
    //                     $shops->setShopsGpvValue($row['NShops']);
    //                     $shops->setActivity($activity);
    //                     $shops->setBrand($brand);
    //                     $em->persist($shops);
    //                     $em->flush();
    //                 }
    //                 // dump($shops);die();
    //                 //loop on shops if exist 
    //                 for ($i=0; $i < 9; $i++) 
    //                 { 
    //                     //get subbrands
    //                    // dump($row['IDBrand']);die();
    //                     $subbrands=$this->getDoctrine()->getRepository('AppBundle:Brand')->getsubBrandsObj($row['IDBrand']);
                        
                        

    //                     if($row['NShops'.$i]!=0)
    //                     {
    //                         //
    //                         $col='nshops'.$i;
    //                         $subbrandName=$this->getDoctrine()->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);
    //                         //get id of sub brand by name
    //                         $subbrand=$this->getDoctrine()->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);
    //                         $shops=new shops();
    //                         $shops->setShopsGpvValue($row['NShops'.$i]);
    //                         $shops->setActivity($activity);
    //                         $shops->setBrand($subbrand);
    //                         $em->persist($shops);
    //                         $em->flush();

    //                     }
    //                    # code...
    //                 }
    //                 //insert new shops activity id and get subbrand[shops prefix] 
    //         }
            
    //     }
       
    //     return $this->apiResponse(null, 'success', 200);

    // }

    /**
    * 
    * @Annotations\Post("api/data/all",name="getAll")
    */

    public function getAll(Request $request)
    {
        //die("asa");

        // set_time_limit(0);
        // ini_set('memory_limit', '4096m');

        // echo 'Ahello'; die;
           
       $data= $this->getDoctrine()->getRepository('AppBundle:RealData')->getAll();  
       // while ($data = $repo->getAll()) {
           // $offset += 1000;
            foreach ($data as $key => $row) {
            
                //get activiy by year and month half and brand and year
            
                $activity=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
                dump($activity);die();
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
                            $shops->setShopsGpvValue($row['NShops']);
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
                                $shops->setShopsGpvValue($row['NShops'.$i]);
                                $shops->setActivity($activity);
                                $shops->setBrand($subbrand);
                                $em->persist($shops);
                                $em->flush();

                            }
                        # code...
                        }
                        //insert new shops activity id and get subbrand[shops prefix] 
                }
                
            }
        //}
       
        return $this->apiResponse(null, 'success', 200);

    }

    
    /**
    * 
    * @Annotations\Get("api/data/gpv/xx",name="getAllGPV")
    */


    public function getGPV()
    {
        //die("sdsd");

       // $doctrine = $this->getContainer()->get('doctrine');
        //$em = $doctrine->getEntityManager();
        $em= $this->getDoctrine();
       $data= $em->getRepository('AppBundle:RealData')->getAll();  
       $m = $this->getDoctrine()->getManager();
       foreach ($data as $key => $row) {
           
           //get activiy by year and month half and brand and year
       
           $activity=$em->getRepository('AppBundle:Activity')->getActivity($row['IDClient'],$row['IDBrand'],$row['WYear'],$row['WMonth'],$row['WHalf']);
       
          // dump($activity);die();
           $client = $em->getRepository('AppBundle:Client')->find($row['IDClient']);
           // dump($client);die();
           $brand = $em->getRepository('AppBundle:Brand')->find($row['IDBrand']);
           //dump($brand);die();

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
                       $m->persist($activity);
                       $m->flush();
                       //$output->writeln('<info>insert new activity</info>');
                   }

                   
                   //insert new row in shops if found brand id and shopsgpv activity id 
                   if($row['NShops']!=0)
                   {
                   
                       //get shops my activity id and brand if exist 
                       $shops=$em->getRepository('AppBundle:shops')->getOneShops($brand->getId(),$activity->getId());
                       if(!$shops)
                       {
                           $shops=new shops();
                           $shops->setActivity($activity);
                           $shops->setBrand($brand);
                           //$output->writeln('<info>insert new shops</info>');
                       }
                       
                       $shops->setShopsGpvValue($row['NShops']);
                       $m->persist($shops);
                       $m->flush();
                      
                   }
                   // dump($shops);die();
                   //loop on shops if exist 
                   for ($i=0; $i < 9; $i++) 
                   { 

                       if($row['NShops'.$i]!=0)
                       {
                           //
                           $col='nshops'.$i;

                           //return brand name 
                           $subbrandName=$em->getRepository('AppBundle:OldBrand')->getSubBrand($col,$row['IDBrand']);

                           //get  brand by name
                           $subbrand=$em->getRepository('AppBundle:Brand')->getsubBrandID($subbrandName[$col]);

                           $shops=$em->getRepository('AppBundle:shops')->getOneShops($subbrand->getId(),$activity->getId());
                           //dump($shops);die;
                           if(!$shops)
                           {
                               $shops=new shops();
                               $shops->setActivity($activity);
                               $shops->setBrand($subbrand);
                               ///$output->writeln('<info>insert new sub brand shops</info>');
                           }
                           $shops->setShopsGpvValue($row['NShops'.$i]);
                           $m->persist($shops);
                           $m->flush();
                           

                       }
                
                   }
                 
           }
           
       }
      // $output->writeln('<info>success goood job............</info>');
        # code...
    }





  
}
