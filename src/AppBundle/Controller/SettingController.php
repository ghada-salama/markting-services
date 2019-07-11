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
use AppBundle\Entity\Activity;
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
use AppBundle\Form\SettingType;



class SettingController extends Controller
{
    use ApiResponseTrait;

    /**
    * 
    * @Annotations\Get("api/grid/setting",name="get_grid_setting")
    * @Annotations\View(serializerGroups={
    *  "grid_setting_component"
    * })
    * @return JsonResponse
    */
   public function getGridSettingAction()
    {

        $setting=$this->getDoctrine()->getRepository('AppBundle:setting')->getSetting();

        $data['number_month']=$setting->getNumberMonth();

        $data['show_last_year']=$this->getDoctrine()->getRepository('AppBundle:setting')->getGridSetting()->getShowLastYear();
        $data['titles']=$this->getDoctrine()->getRepository('AppBundle:setting')->getGridSetting();
        return $data;
        
    }

    /**
    * 
    * @Annotations\Get("api/setting/show",name="get_user_setting")
    * @Annotations\View(serializerGroups={
    *   "setting_component"
    * })
    * @return JsonResponse
    */
   public function getSettingAction()
   {

       //$user=$this->getUser();
       $data=$this->getDoctrine()->getRepository('AppBundle:setting')->getSetting();
       return $data;
       
   }

    /**
    * 
    * @Annotations\Post("api/setting/add",name="add_user_setting")
    * @Annotations\View(serializerGroups={
    *   "setting_component"
    * })
    * @return JsonResponse
    */
//    public function getAddSettingAction(Request $request)
//    {
//        $user=$this->getUser();
//        $userSetting=$this->getDoctrine()->getRepository('AppBundle:setting')->getSetting();
//        $data=$request->getContent();

//        $em = $this->getDoctrine()->getEntityManager();
//        $setting=$this->get('jms_serializer')->deserialize($data,'AppBundle\Entity\setting','json');

//        $em=$this->getDoctrine()->getManager();
//        $em->persist($setting);
//        $em->flush();
//        return $this->apiResponse(null,'success',200);

//    }

    /**
     * @param Request $request
     * @Annotations\Post("api/setting/add",name="add_setting")
     */
    public function addHeader(Request $request)
    {
       
         //die("sdsd");
        $data=$request->getContent();
        $data = json_decode($data);
        //dump($request->request->all());die();
        
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $setting = $this->getDoctrine()->getRepository('AppBundle:setting')->getSetting();
        //dump($setting);die();
        $form = $this->createForm(SettingType::class,$setting);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $setting->setNumberMonth($data->number_month);
            $setting->setShowLastYear($data->show_last_year);
            $setting->setElementsInPage($data->itemsPagedLists);
            $setting->setTheme($data->theme);
            $setting->setNr($data->nr);
            $setting->setFc($data->fc);

            $setting->setOffer(1);
            $setting->setGama(1);
            $setting->setAdditional(1);
            
            //static
            $setting->setKpi($data->kpi);
            $setting->setExposition(1);
            $setting->setOffeQuality(1);
            $setting->setRealShops($data->real_shops);
            $setting->setTotalShops($data->total_shops);
            $setting->setNrVsLy($data->nr_vs_ly);

            $setting->setAutoSaveActivity($data->autoSaveActivity);
            $setting->setWidthOfHalf($data->widthOfHalf);
            $setting->setQuality($data->quality);
            $setting->setThemeImageWidth($data->themeImageWidth);
            $setting->setExportExcel($data->exportExcel);

            $setting->setItemsPagedLists($data->itemsPagedLists);
            $setting->setUsersHelpDocument($data->usersHelpDocument);
            $setting->setAdminHelpDocument($data->adminHelpDocument);
            $setting->setButtonsStyle($data->buttonsStyle);
            $setting->setShowRatio($data->showRatio);

            $setting->setCurrentYearBgcolor($data->currentYearBgcolor);
            $setting->setPreviousYearBgcolor($data->previousYearBgcolor);

            $setting->setSelectedReportSelectorColor($data->selectedReportSelectorColor);
            $setting->setNotSelectedReportSelectorColor($data->notSelectedReportSelectorColor);

            $setting->setGenericActivityColor($data->genericActivityColor);

            $setting->setCurrentYearOfertaColor($data->currentYearOfertaColor);
            $setting->setLastYearOfertaColor($data->lastYearOfertaColor);

            $setting->setCurrentYearTiendasColor($data->currentYearTiendasColor);
            $setting->setLastYearTiendasColor($data->lastYearTiendasColor);

            $setting->setCurrentYearAdicionalColor($data->currentYearAdicionalColor);
            $setting->setLastYearAdicionalColor($data->lastYearAdicionalColor);

            $setting->setCurrentYearFolletoColor($data->currentYearFolletoColor);
            $setting->setLastYearFolletoColor($data->lastYearFolletoColor);

            $setting->setCurrentYearKpiQualityColor($data->currentYearKpiQualityColor);
            $setting->setLastYearKpiQualityColor($data->lastYearKpiQualityColor);

            $setting->setCurrentYearNetRevenueColor($data->currentYearNetRevenueColor);

            $setting->setCurrentYearForecastColor($data->currentYearForecastColor);

            $setting->setCurrentYearNrVsLyColor($data->currentYearNrVsLyColor);

            $setting->setLastYearNetRevenueColor($data->lastYearNetRevenueColor);

            $setting->setLastYearForecastColor($data->lastYearForecastColor);
            $setting->setLastYearNrVsLyColor($data->lastYearNrVsLyColor);

            $setting->setCurrentYearThemeColor($data->currentYearThemeColor);
            $setting->setLastYearThemeColor($data->lastYearThemeColor);

            $setting->setPlanificadoForeground($data->planificadoForeground);
            $setting->setCerradoForeground($data->cerradoForeground);


            //$setting->add('kpi', TextType::class);
            

            


            $em->persist($setting);
            $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
         
      
   }


//    public function createBrand(Request $request)//,Validate $validate
//    {

      

//        $brand=$this->get('jms_serializer')->deserialize($data,'AppBundle\Entity\Brand','json');


//        $reponse=$validate->validateRequest($brand);

//        if (!empty($reponse)){
//            return new JsonResponse($reponse, Response::HTTP_BAD_REQUEST);
//        }

//        $em=$this->getDoctrine()->getManager();
//        $em->persist($brand);
//        $em->flush();


//      return true;
//  }


 
    
}
