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
use AppBundle\Entity\MyFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
class UserController  extends FOSRestController implements ClassResourceInterface 
{

 
  /**
    * 
    * @Annotations\Get("api/user/export",name="get_user_export")
    * @Annotations\View(serializerGroups={
    *   "gride_component","show_activity","get_shops","show_brand","show_client"
    * })
    *export data to excel 
    */

    public function getExportAction(Request $request)
    {
        $users=$this->getDoctrine()->getRepository('AppBundle:UserPassword')->findAll();

                /*********************************export excel****************************************** */

        // ask the service for a Excel5
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
  
        //ask the service for a excel object
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $phpExcelObject->setActiveSheetIndex(0);


        //$phpExcelObject->getActiveSheet()->getRowDimension()->setRowHeight(100);
        $drawingobject = $this->get('phpexcel')->createPHPExcelWorksheetDrawing();
        $drawingobject->setHeight(60);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_DOUBLE,
                    'color' => array('rgb' => '000000')
                )
            )
        );

        $phpExcelObject->getDefaultStyle()->applyFromArray($styleArray);
       //set table caption
       $phpExcelObject->getActiveSheet()->setCellValue('A1','FirstName');
       $phpExcelObject->getActiveSheet()->setCellValue('B1','LastName');
       $phpExcelObject->getActiveSheet()->setCellValue('C1','Email');
       $phpExcelObject->getActiveSheet()->setCellValue('D1','Password');
       $i=2;
       foreach ($users as $key => $user) {
          
            $phpExcelObject->getActiveSheet()->setCellValue('A'.$i,$user->getFirstName());
            $phpExcelObject->getActiveSheet()->setCellValue('B'.$i,$user->getLastName());
            $phpExcelObject->getActiveSheet()->setCellValue('C'.$i,$user->getEmailCanonical());
            $phpExcelObject->getActiveSheet()->setCellValue('D'.$i,$user->getPassword());
           
          $i++;
       }
       $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
       $phpExcelObject->getActiveSheet()->setTitle('Simple');
       //return(get_class_methods($phpExcelObject));die;
       // create the writer
       $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
       //unlink('uploads/excel/exportExcel.xls');
       $writer->save('uploads/excel/userExcel.xls');

       return [
        "url"=>'backend/web/uploads/excel/userExcel.xls',
             "status"=>true
            ];


    }

    

     /**
    *
    * @Route("/api/authmail/{email}",name="show_authmail_mail")
    * @Method({"GET"})
    */
    public function getemail($email)
    {   
       
           $getEmail = $email;
            $getUser = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($getEmail);
                 if ($getUser == null) {
                        return new Response('The email address ' . $getEmail . ' is not attached to an account in Item Master.   <br><br>   Please contact system administrator for support.');
                }
 
                 
                        $user = $getUser;

      /*  $jwt      = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);
        $response = new JWTAuthenticationSuccessResponse($jwt);

        $event = new AuthenticationSuccessEvent(['token' => $jwt], $user, $response);
        $this->get('event_dispatcher')->dispatch(Events::AUTHENTICATION_SUCCESS, $event);
        $response->setData($event->getData());*/
$token = $this->get('lexik_jwt_authentication.jwt_manager')->create($getUser);
        return $token;
        
        
        
        
                //return $token;
    }
    



  
}
