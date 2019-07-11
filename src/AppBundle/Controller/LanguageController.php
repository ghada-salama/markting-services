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



class LanguageController extends Controller
{

    use ApiResponseTrait;

   /**
     * @param Request $request
     * @Annotations\Get("api/language/list",name="list_language ")
     * @Annotations\View(serializerGroups={
     *   "list_lang"
     * })
     */
    public function getlist()
    {
       // die("list msImpact.....");
       $res['data']=$this->getDoctrine()->getRepository('AppBundle:Lang')->getAll();
        return $res;
    }
 
    
}
