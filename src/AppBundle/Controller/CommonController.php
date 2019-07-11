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



class CommonController extends Controller
{

    use ApiResponseTrait;
   
    /**
    * @Annotations\Get("{_locale}/api/msImpact",name="list_msImpact")
    * @Annotations\View(serializerGroups={
    *   "activity_component"
    * })
    */
    public function showMsImpact(Request $reques)
    {
       // die("sdsds");   
        $list_msImpact=$this->getDoctrine()->getRepository('AppBundle:msImpact')->getMsImapact();
        //dump($list_msImpact);die();
        if($list_msImpact){
            return $this->apiResponse($list_msImpact);
        }
      return $this->apiResponse(null, 'not found !', 404);

        
        
    }

      /**
    * @Annotations\Get("{_locale}/api/header",name="list_header")
    * @Annotations\View(serializerGroups={
    *   "activity_component"
    * })
    */
    public function showHeader(Request $reques)
    {
       // die("sdsds");   
        $headers=$this->getDoctrine()->getRepository('AppBundle:header')->getheaders();
        //dump($list_msImpact);die();
        if($headers){
            return $this->apiResponse($headers);
        }
      return $this->apiResponse(null, 'not found !', 404);

        
        
    }



 
    
}
