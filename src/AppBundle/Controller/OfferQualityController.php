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
use AppBundle\Entity\Theme;
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
use AppBundle\Form\ThemeType;



class OfferQualityController extends Controller
{



    /**
     * @param Request $request
     * @Annotations\Get("api/offerquality/list",name="listoffer_quality")
     * @Annotations\View(serializerGroups={
     *   "list_offer"
     * })
     */
    public function listOfferquality()
    {
       // die("list offer.....");
        $res['data']=$this->getDoctrine()->getRepository('AppBundle:OfferQuality')->getAll();
        return $res;
    }


 
    
}
