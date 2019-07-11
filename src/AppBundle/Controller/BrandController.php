<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
//use AppBundle\Service\Validate;
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
use AppBundle\Form\BrandType;
//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BrandController extends Controller
{

    use ApiResponseTrait;
 

    /**
     * @param Request $request
     * @Annotations\Post("api/brand/add",name="create_brand")
     */
    public function addBrand(Request $request)
    {
       
        // die("dfdf");
        $data=$request->getContent();
        $data = json_decode($data);
        $em = $this->getDoctrine()->getManager();
        $Brand = new Brand();
        $form = $this->createForm(BrandType::class,$Brand);
        $form->submit($request->request->all());

        if ($form->isValid()) {
                $Brand->setName($data->name);
                $Brand->setimageH($data->imageH);
                $Brand->setShortName($data->shortName);
                $Brand->setBrandOrder($data->brandOrder);
                $Brand->setSiebelCode($data->siebelCode);
                
                $Brand->setHousehold($data->Household);
                $Brand->setHealthcare($data->Healthcare);
               // $parent = $this->getDoctrine()->getRepository(Brand::class)->find($data->parent);
                //$Brand->setParent($parent);
                $em->persist($Brand);
                $em->flush();
                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
         
      
   }
       /**
     * @param Request $request
     * @Annotations\Post("api/brand/edit/{id}",name="edit_Brand")
     * @ParamConverter("header", class="AppBundle:header")
     */
    public function editBrand(Request $request,$id)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $subBrandNames=$data->subBrand;
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        //$header = new header();
        $Brand = $this->getDoctrine()->getRepository(Brand::class)->find($id);
        $form = $this->createForm(BrandType::class,$Brand);
        $form->submit($request->request->all());

        if ($form->isValid()) {
                $Brand->setName($data->name);
                $Brand->setimageH($data->imageH);
                $Brand->setShortName($data->shortName);
                $Brand->setBrandOrder($data->brandOrder);
                $Brand->setSiebelCode($data->siebelCode);
                
                $Brand->setHousehold($data->Household);
                $Brand->setHealthcare($data->Healthcare);
                
                //$parent = $this->getDoctrine()->getRepository(Brand::class)->find($data->parent);
                //$Brand->setParent($parent);
                $em->persist($Brand);
                $em->flush();

                //TO DO delete  brand subbrands to add new collection
                $subBrands=$Brand->getChildren();
                if(Count($subBrands)>0)
                {
                    foreach ($subBrands as $subBrand) {
                        $subBrand->setFlag(1);
                        $em->persist($Brand);
                        $em->flush();
                    }

                }

                //add new subbrands
                foreach ($subBrandNames as  $subBrandName) 
                {
                    $subBrandName = new Brand();
                    $subBrandName->setName($subBrandName);
                    $subBrandName->setParent($Brand->getId());
                    $em->persist($Brand);
                    $em->flush();
                }
                 

                return $this->apiResponse(null, 'success', 200);
        }
        return $form;
      
   }

   
    /**
     * @Route("/api/brand/delete",name="delete_Brand")
     * @Annotations\View()
     * @Method({"Post"})
     */

    public function deleteBrand(Request $request)
    {
        $data=$request->getContent();
        $data = json_decode($data);
        $ids=$data->id;

        $Brands=$this->getDoctrine()->getRepository('AppBundle:Brand')->getBrandsObjectById($ids);
        foreach ($Brands as  $Brand) 
        {
            $em=$this->getDoctrine()->getManager();
            $Brand->setFlag(1);
            $em->persist($Brand);
            $em->flush(); 
        }
 
        return $this->apiResponse(null, 'success', 200);
    }

   


   /**

     *
     * @param Request $request
     * @param Validate $validate
     * @Annotations\View()
     * @Route("/api/brands",name="create_brand")
     * @Method({"POST"})
     */
//     public function createBrand(Request $request)//,Validate $validate
//     {

//         $data=$request->getContent();

//         $brand=$this->get('jms_serializer')->deserialize($data,'AppBundle\Entity\Brand','json');


//         $reponse=$validate->validateRequest($brand);

//         if (!empty($reponse)){
//             return new JsonResponse($reponse, Response::HTTP_BAD_REQUEST);
//         }

//         $em=$this->getDoctrine()->getManager();
//         $em->persist($brand);
//         $em->flush();


//       return true;
//   }
   
 

    /**

     * @Route("/api/brands/{order}",name="list_brands_order")
     * @Method({"POST"})
     * @Annotations\View(serializerGroups={
     *   "list_brands"
     * })
     * 
     */

    public function listBrands(Request $request,$order)
    {
        $data=$request->getContent();
        $getJson = json_decode($data);
        $ids=$getJson->ids;

        $user=$this->getUser();
        $userHealthCare = $user->getHealthcare();
        if($userHealthCare==null){
            $userHealthCare=0;
        }
        
        $userHealthHold = $user->getHousehold();
       if($userHealthHold==null){
            $userHealthHold=0;
        }
        
        //TODO:array or ids 
        if($userHealthCare==0 && $userHealthHold==0){
             $clients = [];
        }else{
             $clients = $this->getDoctrine()->getRepository('AppBundle:Brand')->getBransOrderBy($ids,$order,$userHealthCare,$userHealthHold); 
         }
        
        $res['brands'] = $clients;//$pagination->getItems();
        return $res;
     
    }
      /**

     * @Route("/api/brands/{order}",name="get_list_brands_order")
     * @Method({"GET"})
     * @Annotations\View(serializerGroups={
     *   "list_brands"
     * })
     * 
     */

    public function getListBrands(Request $request,$order)
    {
       // $data=$request->getContent();
       // $getJson = json_decode($data);
       // $ids=$getJson->ids;

        
           $user=$this->getUser();
        $userHealthCare = $user->getHealthcare();
        if($userHealthCare==null){
            $userHealthCare=0;
        }
        
        $userHealthHold = $user->getHousehold();
       if($userHealthHold==null){
            $userHealthHold=0;
        }
        
        
         if($userHealthCare==0 && $userHealthHold==0){
             $clients = [];
        }else{
           $clients=$this->getDoctrine()->getRepository('AppBundle:Brand')->getListBransOrderBy($order,$userHealthCare,$userHealthHold); 
         
        }
        //TODO:array or ids 
        $res['brands'] = $clients;//$pagination->getItems();
        return $res;
     
    }

    
    
    
    
    
    /**

     * @Route("/api/brandsadmin/{order}",name="get_list_brandsadmin_order")
     * @Method({"GEt"})
     * @Annotations\View(serializerGroups={
     *   "list_brands"
     * })
     * 
     */

    public function getListBrandsadmin(Request $request,$order)
    {
       // $data=$request->getContent();
       // $getJson = json_decode($data);
       // $ids=$getJson->ids;

        
      
        
         
           $clients=$this->getDoctrine()->getRepository('AppBundle:Brand')->getListBransadminOrderBy($order); 
         
         
        //TODO:array or ids 
        $res['brands'] = $clients;//$pagination->getItems();
        return $res;
     
    }
    
    
    /**

     * @Route("/api/brands/orderlist",name="list_brands_order_by_name")
     * @Method({"GET"})
     * @Annotations\View()
     * 
     */

    // public function listOrderBrands()
    // {

      
    //    $brands=$this->getDoctrine()->getRepository('AppBundle:Brand')->getBrandsOrderByName();
    //     $data['brands'] = $brands;
    //      return $data;
         
    // }
    
    


    /**
     * @Route("/api/brands/{brand}/delete",name="delete_brand")
     * @ParamConverter("brand", class="AppBundle:Brand") 
     * @Method({"GET"})
     */

//     public function deleteBrand($brand)
//     {
//        $em=$this->getDoctrine()->getManager();
//         $brand->setFlag(1);
//         $em->persist($brand);
//         $em->flush(); 
//       return true;
//   }
  
  
  
  
  
  
  
    /**
     * @Route("/api/subbrands/delete",name="delete_subbrand")
     * @Method({"POST"})
     */

    public function deletesubBrand(Request $request)
    {
        $data=$request->getContent();
        $getJson = json_decode($data);
        
        foreach($getJson->brands as $jsonItm){
            if(isset($jsonItm->id)){
                $getId = $jsonItm->id;
                $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->findOneById($jsonItm->id);
                $brand->setFlag(1);
                  $em=$this->getDoctrine()->getManager();
                 $em->persist($brand);
                 $em->flush();
            }
        }
        
       return true;
       
      
  }
  


    
    
      /**
     * @ApiDoc(
     * description="update a Brand",
     *
     *    statusCodes = {
     *        201 = "Creation with success",
     *        400 = "invalid form"
     *    },
     *    responseMap={
     *         201 = {"class"=Brand::class},
     *
     *    },
     *     section="brands"
     *
     *
     * )
     *
     * @param Request $request
     * @param Validate $validate
     * @return JsonResponse
     * @ParamConverter("brand", class="AppBundle:Brand")
     * @Route("/api/brands/{brand}/update",name="update_brand")
     * @Method({"POST"})
     */
    // public function updatebrand(Request $request,$brand,Validate $validate)
    // {
    //     $data=$request->getContent();
    //     $getJson = json_decode($data);
    //     if(isset($getJson->name)){
    //         $brand->setName($getJson->name);
    //     }
    //     if(isset($getJson->plantTo)){
    //         $brand->setShortName($getJson->shortName);
    //     }
    //     if(isset($getJson->clientOrder)){
    //          $brand->setBrandOrder($getJson->brandOrder);
    //     }
    //     if(isset($getJson->siebelCode)){
    //         $brand->setSiebelCode($getJson->siebelCode);
    //     }
    //     if(isset($getJson->imageH)){
    //         $brand->setImageH($getJson->imageH);
    //     }
    //     if(isset($getJson->imageV)){
    //         $brand->setImageV($getJson->imageV);
    //     }
    //     if (!empty($reponse)){
    //         return new JsonResponse($reponse, Response::HTTP_BAD_REQUEST);
    //     }
    //     $em=$this->getDoctrine()->getManager();
    //     $em->persist($brand);
    //     $em->flush();
    //    return true;
    // }
    




    
    
      /**
     * @ApiDoc(
     * description="update a sub Brand",
     *
     *    statusCodes = {
     *        201 = "Creation with success",
     *        400 = "invalid form"
     *    },
     *    responseMap={
     *         201 = {"class"=Brand::class},
     *
     *    },
     *     section="brands"
     *
     *
     * )
     *
     * @param Request $request
     * @param Validate $validate
     * @return JsonResponse
     * @Route("/api/subbrands/update",name="update_subbrand")
     * @Method({"POST"})
     */
    // public function updatesubbrand(Request $request,Validate $validate)
    // {
    //     $data=$request->getContent();
    //     $getJson = json_decode($data);
    //     //print'<pre>'; print_r($getJson); print'</pre>';
    //    // die();
    //     foreach($getJson->brands as $jsonItm){
    //         if(isset($jsonItm->name)){
    //             $getId = $jsonItm->id;
    //             $brand=$this->getDoctrine()->getRepository('AppBundle:Brand')->findOneById($getId);
    //             $brand->setName($jsonItm->name);
               
    //             $em=$this->getDoctrine()->getManager();
    //             $em->persist($brand);
    //             $em->flush();
    //         }
    //     }
        
     
    //    return true;
    // }    
    
    /**
     *@ApiDoc(
     *      resource=true,
     *     description="Get one  client",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The client unique identifier."
     *         }
     *     },
     *     section="brands"
     * )
    * @Route("/api/brands/{brand}/showupdate",name="show_brand_update")
    * @ParamConverter("brand", class="AppBundle:Brand")
    * @Method({"GET"})
    */
    public function updateviewclient($brand,Request $request)
    {   
       $data=$this->get('jms_serializer')->serialize($brand,'json');
        return $data;
    }
    
    
    

    
	
    /**
    * @Route("/api/codes/{name}/{year}",name="show_codes")
    * @Method({"GET"})
    */
    public function getcodes(Request $request,$name,$year)
    {   
           // set doctrine
			$em = $this->get('doctrine')->getManager()->getConnection();

			// prepare statement
			$sth = $em->prepare("CALL XLDatosIntranet('$name',$year)");

			// execute and fetch
			$sth->execute();
			$result = $sth->fetchAll();
	     
			 $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
			 $phpExcelObject->setActiveSheetIndex(0);
			//$spreadsheet = new Spreadsheet();
			//$sheet = $spreadsheet->getActiveSheet();
			
			$iii=6;
			foreach($result as $keyOne => $resItm){
				$ii=0;
				 array_shift($resItm);
				 foreach($resItm as $keyTwo => $resItmChild){
						$nameCode = $this->getNameFromNumber($ii);
						$phpExcelObject->getActiveSheet()->setCellValue($nameCode.$iii,$resItmChild);
						$ii=$ii+1;
				 }
				 $iii=$iii+1;
			}
			
			
		//  $writer = new Writer\Xls($spreadsheet);
		//	$writer->save('uploads/excel/uploadfile.xls');
	   $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
       //unlink('uploads/excel/exportExcel.xls');
       $writer->save('uploads/excel/uploadfile.xls');
		   
		   
		   
		   
		   
		   
		   
		   
		    // set doctrine
			$em = $this->get('doctrine')->getManager()->getConnection();

			// prepare statement
			if($sub=='parent'){
				$sth = $em->prepare("CALL XLIntranetBrands('$name',$year)");
			} else {
				$sth = $em->prepare("CALL XLIntranetBrandssub('$name',$year)");
			}

			// execute and fetch
			$sth->execute();
			$result = $sth->fetchAll();
	     
			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
			$phpExcelObject->setActiveSheetIndex(0);
			
			$iii=6;
			foreach($result as $keyOne => $resItm){
				$ii=1;
				 array_shift($resItm);
				 foreach($resItm as $keyTwo => $resItmChild){
						$nameCode = $this->getNameFromNumber($ii);
						$phpExcelObject->getActiveSheet()->setCellValue($nameCode.$iii,$resItmChild);
						$ii=$ii+1;
				 }
				 $iii=$iii+1;
			}
			
			
		     $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
       //unlink('uploads/excel/exportExcel.xls');
       $writer->save('uploads/excel/uploadfile2.xls');
		   
		   
		   
		   
		  die();
	 
	 }
	
         
    /**
    * @Route("/api/generatesheet/{name}/{year}/{sub}",name="show_codes")
    * @Method({"GET"})
    */
    public function generatesheet(Request $request,$name,$year,$sub)
    {   
        
        $fileName=$name.'_'.$year.'.xls';
        $fileName2=$name.'_'.$year.'2.xls';
           // set doctrine
			$em = $this->get('doctrine')->getManager()->getConnection();

			// prepare statement
			if($sub=='parent'){
				$sth = $em->prepare("CALL XLDatosIntranet('$name',$year)");
			} else {
				$sth = $em->prepare("CALL XLDatosIntranetsub('$name',$year)");
			}
			
			// execute and fetch
			$sth->execute();
			$result = $sth->fetchAll();
	     
			 $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
			 $phpExcelObject->setActiveSheetIndex(0); 
			
			$iii=6;
			foreach($result as $keyOne => $resItm){
				$ii=0;
				 array_shift($resItm);
				 foreach($resItm as $keyTwo => $resItmChild){
						$nameCode = $this->getNameFromNumber($ii);
						$phpExcelObject->getActiveSheet()->setCellValue($nameCode.$iii,$resItmChild);
						$ii=$ii+1;
				 }
				 $iii=$iii+1;
			}
		 
                     $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
                     $writer->save('uploads/excel/'.$fileName);
		    
		    // set doctrine
			$em = $this->get('doctrine')->getManager()->getConnection();

		 	if($sub=='parent'){
				$sth = $em->prepare("CALL XLIntranetBrands('$name',$year)");
			} else {
				$sth = $em->prepare("CALL XLIntranetBrandssub('$name',$year)");
			}
			
			// execute and fetch
			$sth->execute();
			$result = $sth->fetchAll();
	     
			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
			$phpExcelObject->setActiveSheetIndex(0);
			
			$iii=6;
			foreach($result as $keyOne => $resItm){
				$ii=1;
				 array_shift($resItm);
				 foreach($resItm as $keyTwo => $resItmChild){
						$nameCode = $this->getNameFromNumber($ii);
						$phpExcelObject->getActiveSheet()->setCellValue($nameCode.$iii,$resItmChild);
						$ii=$ii+1;
				 }
				 $iii=$iii+1;
			}
			
			
		     $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
       //unlink('uploads/excel/exportExcel.xls');
       $writer->save('uploads/excel/'.$fileName2);
		   
		   
		   
		   print '<h2>done</h2>';
		  die();
	 
	 }
         
         
	 public function uploadFile($file) {
       
        $fileSize = $file['model']->getSize();
        $filePath = $file['model']->getPathName();  
		print $filePath;
        if ($fileSize > 155242880) {
            die("File size is too big!");
        }

        if ($this->zipIsValid($filePath) == false) {
            die('not supported file');
        }

		$fileName='filename';
        $brochuresDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads';
		$file['model']->move($brochuresDir, $fileName);
         
        die('Success! File Uploaded.');
    }
	
	
	    public function getNameFromNumber($num) {
			$numeric = $num % 26;
			$letter = chr(65 + $numeric);
			$num2 = intval($num / 26);
			if ($num2 > 0) {
				return $this->getNameFromNumber($num2 - 1) . $letter;
			} else {
				return $letter;
			}
		}

	
}
