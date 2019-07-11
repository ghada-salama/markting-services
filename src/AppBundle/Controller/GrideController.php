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
class GrideController  extends FOSRestController implements ClassResourceInterface 
{

    use ApiResponseTrait;


  /**
    * 
    * @Annotations\Post("api/grid/data",name="get_data")
    * @Annotations\View(serializerGroups={
    *   "gride_component","show_activity","get_shops"
    * })
    
    */

    public function getGrideAction(Request $request)
    {
        $user=$this->getUser();

        //die("fdsds");
        $locale=$user->getIso();
        //dump($this->session->set('_locale', $user->getIso()));die("aaaaa");
        if($locale){
            $request->setLocale($locale);
        }
        $lo = $request->getLocale();
        $data=$request->getContent();
        $getJson = json_decode($data);
        //dump($getJson);die();
        $titles=$getJson->titles;
        $mode=$getJson->mode;
        $id=$getJson->id;
        $rows=[];//$getJson->rows;
       // $rows=$getJson->clients;
        //$rows=$getJson->bran;

        $view;
        if($mode==0)
        {
           //one client all brand mode
            $view=$this->getDoctrine()->getRepository('AppBundle:Client')->find($id);
            $rows=$getJson->brands;
        }else
        {
            //one brand all client mode
            $view=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($id);
            $rows=$getJson->clients;

        } 
        if($view==null)
        {
            return $this->apiResponse(null, 'not found !', 404);
        }


        $translated_titles=[];
        $translated_monthes=[];
        $translated_monthes_name=[];
        $half_months=["1half"=>"1st Half","2half"=>"2st Half"];
        
        $result=[];

        //set filters 
        //set defult values
        //TODO:get filtters form user setting
        $filters['year']=$request->get('_year')?$getJson->_year:date("Y"); 

        //$filters['rows']=$mode;
        $filters['start_month']=$request->get('start_month')?$request->get('start_month'):1;
        $filters['number_month']=$request->get('number_month')?$request->get('number_month'):13;
        $filters['show_last_year']=$getJson->show_last_year;
        $filters['user']= $user;
       // dump($filters);die();

        //translate title  if key true
        foreach($titles as $key=>$flage)
        {
            if($flage)
            {
                //$request->setLocale($locale);
                $translated_titles[$key]=$this->get('translator')->trans($key);

                        
            }
        }
        //translate month
        $end_month=($filters['start_month']+$filters['number_month'])-1;
        for ($month=$filters['start_month']; $month <= $end_month ; $month++) 
        {
            $monthNumber=(int)$month;
            if($month >12)
            {
                // echo gettype($month);die; 
                $monthNumber=(int)($month-12);
            }
            $translated_monthes[(int)$monthNumber]=$this->get('translator')->trans((int)$monthNumber);
            $translated_monthes_name[]=$this->get('translator')->trans($monthNumber);
        }
        //translated month and yaer
        


        //translate half months
        foreach ($half_months as $key => $value) 
        {

            $filters['half_months'][$key]=$this->get('translator')->trans($key);
        }
    
    
        $filters['titles']=$translated_titles;
        $filters['translated_monthes']=$this->getTraslatedMonthsRang($filters);//$translated_monthes;
        $filters['translated_monthes_name']=$translated_monthes_name;
        
        
         $user=$this->getUser();
         
         $userHealthCare = $user->getHealthcare();
         if($userHealthCare==null){
            $userHealthCare=0;
         }
        
        $userHealthHold = $user->getHousehold();
        if($userHealthHold==null){
            $userHealthHold=0;
         }
        
        
        
        $filters['healthcare'] = $userHealthCare;
        $filters['household'] = $userHealthHold;
        
        $result=$this->getDoctrine()->getRepository('AppBundle:Activity')->getActivities($mode,$id,$rows,$filters);
        //clear log
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        return $result; 
    }

    public function getTraslatedMonthsRang($filters)
    {
         $date=date("Y-m-d",mktime(0,0,0,$filters['start_month'],1,$filters['year']));     //2018-12-01
        // dump($date);die;
         $startdate= strtotime($date);                                                    //1543618800
         $enddata= strtotime($date. " +".$filters['number_month']."month");
         $rang=[];
        while ($startdate < $enddata)
        {

           $month=date('m', $startdate);
           $year=date('Y', $startdate);
           $month=date('m', $startdate);
           $monthNumber=(int)$month;
           if($month >12)
           {
               // echo gettype($month);die; 
               $monthNumber=(int)($month-12);
           }
           $monthNumber=$this->get('translator')->trans($monthNumber);
           
           $rang[] =['month'=>$monthNumber,'year'=>$year];
           $startdate = strtotime("+1 month", $startdate);

       }
      return $rang;
       
    }


    /**
    * 
    * @Annotations\Post("api/grid/data/export",name="get_data_export")
    * @Annotations\View(serializerGroups={
    *   "gride_component","show_activity","get_shops","show_brand","show_client"
    * })
    *export data to excel 
    */

    public function getExportGrideAction(Request $request)
    {

        $data=$request->getContent();
        $getJson = json_decode($data);
        $titles=$getJson->titles;
        $mode=$getJson->mode;
        $id=$getJson->id;
        //$rows=$getJson->rows;

         $rows=[];

         if($mode==0)
         {
            //one client all brand mode
             $view=$this->getDoctrine()->getRepository('AppBundle:Client')->find($id);
             $rows=$getJson->brands;
         }else
         {
             //one brand all client mode
             $view=$this->getDoctrine()->getRepository('AppBundle:Brand')->find($id);
             $rows=$getJson->clients;
 
         } 

        
        //dump($rows);die;
        $view=$mode==0?$this->getDoctrine()->getRepository('AppBundle:Client')->find($id):$this->getDoctrine()->getRepository('AppBundle:Brand')->find($id);
       // dump($view);die;
        $filters['start_month']=$request->get('start_month')?$request->get('start_month'):1;
        $filters['number_month']=$request->get('number_month')?$request->get('number_month'):13;
        $filters['show_last_year']=$getJson->show_last_year;
        $user=$this->getUser();
        $filters['user']= $user;
        if($view==null)
        {
            return $this->apiResponse(null, 'not found !', 404);
        }

        //TODO:get filtters form user setting
        $filters['year']=$request->get('_year')?$getJson->_year:date("Y"); 

        //translate title  if key true
        foreach($titles as $key=>$flage)
        {
            if($flage)
            {
                $translated_titles[$key]=$this->get('translator')->trans($key);
                        
            }
        }
        

        //translate month
        $end_month=($filters['start_month']+$filters['number_month'])-1;
        for ($month=$filters['start_month']; $month <= $end_month ; $month++) 
        {
            $monthNumber=(int)$month;
            if($month >12)
            {
                // echo gettype($month);die; 
                $monthNumber=(int)($month-12);
            }
            $translated_monthes[(int)$monthNumber]=$this->get('translator')->trans((int)$monthNumber);
            $translated_monthes_name[]=$this->get('translator')->trans($monthNumber);
        }


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
        //merge
        $start_col=range('A', 'Z');
        $phpExcelObject->getActiveSheet()->mergeCells('A1:C7');
        $phpExcelObject->getActiveSheet()->mergeCells('D1:Z6');
        for ($i=1; $i <6 ; $i++) 
        { 
           // $phpExcelObject->getActiveSheet()->mergeCells('A'.$i.':Z'.$i);
            $phpExcelObject->getActiveSheet()->mergeCells($start_col[($i-1)].'1:'.$start_col[$i-1].'6');
            //dump('A'.$i.':Z'.$i);
            //dump($start_col[($i-1)].'1:'.$start_col[$i-1].'6');
        }
        $col=range('D', 'Z');
        $col= array_merge($col,['AA','AB','AC','AD','AE','AF','AG']);
       // return $col;
        $start_brand=9;
        $start_month=$start_brand-2;
        foreach ($translated_monthes_name as $key => $month)
         {
            $start=$key*2;      //0 - 2  - 4
            $end=($key*2)+1;    //1 - 3  - 5

            $phpExcelObject->getActiveSheet()->setCellValue($col[$start].$start_month,$month); //D7 //F7 //H7

            $phpExcelObject->getActiveSheet()->mergeCells($col[$start].$start_month.':'.$col[$end].$start_month);
            $style = array(
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
            );

            $phpExcelObject->getActiveSheet()->getStyle($col[$start].$start_month.':'.$col[$end].$start_month)
                                             ->applyFromArray($style);


            //half
           $phpExcelObject->getActiveSheet()->setCellValue($col[$start].($start_month+1),'Q1');
           $phpExcelObject->getActiveSheet()->setCellValue($col[$end].($start_month+1),'Q2');

           
        }
        $filters['titles']=$translated_titles;
        $filters['translated_monthes']=$this->getTraslatedMonthsRang($filters);//$translated_monthes;
        $filters['translated_monthes_name']=$translated_monthes_name;
         $result=[];
        /**get client or brand and rows**/
        $client=$this->getDoctrine()->getRepository('AppBundle:Activity')->getView($mode,$id); //return client or brand related to view
        $my_rows=$this->getDoctrine()->getRepository('AppBundle:Activity')->getRowsExport($mode,$rows); //return brands if mode ==0 and clients if mode ==1 
        //dump($rows);die;
        //return $view;


        //client or brand name
        $data=date("Y-m-d H:i:s"); 
        $phpExcelObject->getActiveSheet()->setCellValue('A1','SOA Reporting Trade Marketing Analysis ');
        $phpExcelObject->getActiveSheet()->setCellValue('A2',' Trade Marketing Analysis');
        $phpExcelObject->getActiveSheet()->setCellValue('D1','Generated from SOA Online:'.$data);
        $style = array(
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
            'font'  => array(
                'bold'  => true,
                'size'  => 16,
                'name'  => 'Verdana'
            )
        );
        $style2 = array(
            'alignment' => array('vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP)
        );
        
        $phpExcelObject->getActiveSheet()->getStyle('A1')->applyFromArray($style);
        $phpExcelObject->getActiveSheet()
                    ->getStyle('A1')
                    ->getAlignment()
                    ->setWrapText(true);
        $phpExcelObject->getActiveSheet()->getStyle('D1')->applyFromArray($style2);
        $viewImage=$view->getImageHExcle();
        if($viewImage!=null && file_exists($viewImage)) 
                    {
                        //$brandImageUrl =  'C:/xampp/htdocs/soa/web/uploads/gallery/AIRWICKH.jpg'; 
						
                        $writer = $this->get('phpexcel')->createPHPExcelObject();
                              $writer->setActiveSheetIndex(0);
                              $activesheet = $writer->getActiveSheet();
                               $drawingobject = $this->get('phpexcel')->createPHPExcelWorksheetDrawing();
                              $drawingobject->setName($view->getName());
                              $drawingobject->setDescription($view->getName());
                              $drawingobject->setPath($viewImage,true);
                              $drawingobject->setHeight(60);
                              $drawingobject->setWidth(60);
                              $drawingobject->setCoordinates('A8');
                              $drawingobject->setOffsetX(0);
                              $drawingobject->setOffsetY(0);
                              //$drawingobject->setRotation(60);
                              $drawingobject->getShadow()->setVisible(true);
                              $drawingobject->getShadow()->setDirection(45);
                              $drawingobject->setWorksheet( $phpExcelObject->getActiveSheet());
						
                        

                    }else
                    {
                        $phpExcelObject->getActiveSheet()->setCellValue('A8',$view->getName());
                    }
					
					//$phpExcelObject->getActiveSheet()->setCellValue('A8',$view->getName());
					
        $phpExcelObject->getActiveSheet()->mergeCells('A8:C8'); //A7

        foreach ($my_rows as $key => $row) 
        {

            ///loop on brand

                $years=$this->getDoctrine()->getRepository('AppBundle:Activity')->getYearsName($filters);//[2017]or [2017,2018]
                //dump($years);die;
                $brandName=$row->getName();
                $image=$row->getImageHExcle();
                
                //get  qurteres per row  
                $quarters=$this->getDoctrine()->getRepository('AppBundle:Activity')->getQuartersExport($mode,$id,$row,$filters);
               // print_r($quarters);
                $quartersCount=count($years)==2?(count($quarters)*2):count($quarters);
                $data=$this->getDoctrine()->getRepository('AppBundle:Activity')->getSortedActivitiesExcel($mode,$id,$row,$filters,$years);

                //display image 
                //return $this->get('kernel')->getRootDir().'/../web/uploads/gallery/AIRWICKH.jpg';
                 //$ImageUrl="http://soa.rbnse.pro/backend/web/uploads/gallery/".$image;
                  //$brandImageUrl=$this->get('kernel')->getRootDir().'/../web/uploads/gallery/AIRWICKH.jpg';
                  
                   // get image or name
                  //  $$this->get('kernel')->getRootDir().'/../web/uploads/gallery/AIRWICKH.jpg'
                    if($image!=null && file_exists($image)) 
                    {
                        $writer = $this->get('phpexcel')->createPHPExcelObject();
                        $writer->setActiveSheetIndex(0);
                        $activesheet = $writer->getActiveSheet();
                        $drawingobject = $this->get('phpexcel')->createPHPExcelWorksheetDrawing();      
                        $drawingobject->setName('logo');
                        $drawingobject->setDescription('logo');
                        $drawingobject->setPath($image,true);
                        //$objDrawing->setPath();
                        $drawingobject->setCoordinates('A'.$start_brand);
                        $drawingobject->setOffsetX(0);
                        $drawingobject->setOffsetY(0);
                        //$drawingobject->setRotation(60);
                        $drawingobject->getShadow()->setVisible(true);
                        $drawingobject->getShadow()->setDirection(45);
                        $drawingobject->setWorksheet( $phpExcelObject->getActiveSheet());
						
                    }
                    else
                    {
                       $phpExcelObject->getActiveSheet()->setCellValue('A'.$start_brand,$brandName);
                    }
					
					//$phpExcelObject->getActiveSheet()->setCellValue('A'.$start_brand,$brandName);
					
                    //$phpExcelObject->getActiveSheet()->setCellValue('A'.$start_brand,$brandName);
                    //$phpExcelObject->getActiveSheet()->setCellValue('A'.$start_brand,$brandName);
                   

                    //merge cells
                    $phpExcelObject->getActiveSheet()->mergeCells('A'.$start_brand.':'.'A'.(($start_brand + $quartersCount) - 1));

                    //set double
                    $style = array(
                        
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_DOUBLE,
                                'color' => array('rgb' => '000000')
                            )
                        )
                    );
                    
                   // $phpExcelObject->getActiveSheet()->getStyle('B'.$start_year)->applyFromArray($style);
                    $phpExcelObject->getActiveSheet()->getStyle('A'.($start_brand + $quartersCount).':Z'.($start_brand + $quartersCount))->applyFromArray($style);
                    //set double border
                   // $phpExcelObject->getActiveSheet()->mergeCells('A'.(($start_brand + $quartersCount)):'Z'.(($start_brand + $quartersCount)));
                    //applay style 
                    $style = array(
                        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                    );
                    $phpExcelObject->getActiveSheet()->getStyle('A'.$start_brand)->applyFromArray($style);

                    //setCellValue year
                $start_querter=$start_brand;
                foreach ($years as $key => $year)
                {
                    $dataByYear=$data[$year];
                    //return $dataByYear;
                    $currentYear= $year==$filters['year']?true:false;
                    //print_r($currentYear);
                    $start_year=$key==0?$start_brand:$start_brand +count($quarters);
                   // $quartersCount=count($years)==2?$quartersCount/2:$quartersCount;
                   $end_year=$key==0?$start_brand+(count($quarters)) - 1:$start_brand+(count($quarters)*2) - 1;
                    $phpExcelObject->getActiveSheet()->setCellValue('B'.$start_year,$year);
                    $phpExcelObject->getActiveSheet()->mergeCells('B'.$start_year.':'.'B'.$end_year);
                    $style = array(
                        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                    
                    );
                    $color=$this->getColor($currentYear,'year');
                    $style = array(
                        'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb'=>str_replace('#', '', $color)),
                        ),
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('rgb' => 'cccccc')
                            )
                        )
                    );
                    
                    $phpExcelObject->getActiveSheet()->getStyle('B'.$start_year)->applyFromArray($style);
                   // $phpExcelObject->getActiveSheet()->getStyle('B'.$start_year)->applyFromArray($style);
                  
                    foreach ($quarters as $key2 => $quarterName)
                    {
                     
                        $phpExcelObject->getActiveSheet()->setCellValue('C'.$start_querter,$quarterName['name']);
                        $style = array(
                            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                        
                        );
                        $color=$this->getColor($currentYear,'YEAR');
                        //print_r(str_replace('#', '', $color));print_r("</br>");
                        $style = array(
                                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                                'fill' => array(
                                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb'=>str_replace('#', '', $color)),
                                )
                                ,
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                        'color' => array('rgb' => 'cccccc')
                                    )
                                    )
                        );
                        
                        $phpExcelObject->getActiveSheet()->getStyle('C'.$start_querter)->applyFromArray($style);
                      

                        $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

                       // return $data;
                        //loop on data
                        $start_data=$start_querter;
                        $rowDim=$start_data;
                      //  $colQuerter=
                        foreach ($dataByYear as $key3 => $row) 
                        {
                            //return $row;
                            $phpExcelObject->getActiveSheet()->getRowDimension($rowDim)->setRowHeight(40);
                            $rowDim=$rowDim+1;
                           
                            //dump($row[$quarterName['value']]['name']);die;
                            //D9 
                            $phpExcelObject->getActiveSheet()->setCellValue($col[$key3].$start_data,$row[$quarterName['value']]['name']);
                            
                            
                            $phpExcelObject->getActiveSheet()->getColumnDimension($col[$key3])->setAutoSize(true);
                            $style = array(
                                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                            
                            );
                            if($row[$quarterName['value']]['name']!=null)
                            {
                            $color=$this->getColor($currentYear,$quarterName['value']);
                            
                            //get text color
                            $textColor='000000';
                            if($quarterName['value']=='offer')
                            {
                                if($row[$quarterName['value']]['statusvalue']!=null||$row[$quarterName['value']]['statusvalue']!=""&&$row[$quarterName['value']]['statusvalue']==2)
                                {
                                    $textColor='ff0000';
                                }

                            }
                            $style = array(
                                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical' => \PHPExcel_Style_Alignment::VERTICAL_TOP),
                                'fill' => array(
                                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb'=>str_replace('#', '', $color)),
                                ),
                                'borders' => array(
                                    'allborders' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                                        'color' => array('rgb' => 'cccccc')
                                    )
                                ),
                                'font'  => array(
                                    'color'  =>array('rgb' => $textColor)
                                )
                            );

                            $phpExcelObject->getActiveSheet()->getStyle($col[$key3].$start_data)->applyFromArray($style);//->setBorder('thin', 'thin', 'thin', 'thin');;
                            }
                            //merge fc nr 
                            
                           
                        }
                        $start_querter++;

                    }

                }


                $start_brand=$start_brand + 1 +$quartersCount;
           
        }
   

    $phpExcelObject->getActiveSheet()->setTitle('Simple');
    //return(get_class_methods($phpExcelObject));die;
    // create the writer
    $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
   // ob_end_clean();
    //unlink('uploads/excel/exportExcel.xls');
    //==
    $response = $this->get('phpexcel')->createStreamedResponse($writer);
    // adding headers
    // $dispositionHeader = $response->headers->makeDisposition(
    //     ResponseHeaderBag::DISPOSITION_ATTACHMENT,
    //     'PhpExcelFileSample.xls'
    // );
    // $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
    // $response->headers->set('Pragma', 'public');
    // $response->headers->set('Cache-Control', 'maxage=1');
    // $response->headers->set('Content-Disposition', $dispositionHeader);

    //==
    $writer->save('uploads/excel/exportExcel.xls');
    //$dir=$this->container->getParameter('excel_directory');
    //return $dir;
    return [
        "url"=>'backend/web/uploads/excel/exportExcel.xls',
             "status"=>true
            ];
  
        
    }

    public function getColor($currentYear,$key)
    {
       // print_r($key);print_r($currentYear);print_r("</br>");
       if($key!='nr_vs_ly'||$key!='offer'||$key!='kpi'||$key!='nr_vs_ly'||$key!='gama'||$key!='hq_shops'||$key!='nr'||$key!='fc')
       {
         $prefix=explode ('_',$key);
         $key=$prefix[0];
       }
       $setting=$this->getDoctrine()->getRepository('AppBundle:setting')->getSetting();
       $color=$currentYear==true?$setting->getCurrentYearBgcolor():$setting->getPreviousYearBgcolor();

        switch ($key) {

            case 'offer':
            $color=$currentYear==true?$setting->getCurrentYearOfertaColor():$setting->getLastYearOfertaColor();
           // print_r($color);die;
           // return $color;
            break;

            case 'kpi':
            $color=$currentYear==true?$setting->getCurrentYearKpiQualityColor():$setting->getLastYearKpiQualityColor();
           // print_r($color);die;
          //  return $color;
            break;

            case 'gama':
            $color=$currentYear==true?$setting->getCurrentYearFolletoColor():$setting->getLastYearFolletoColor();
           // print_r($color);die;
            //return $color;
            break;


            case 'hq_shops':
            case 'gpv_shops':
            case 'hq':
            case 'gpv':
            $color=$currentYear==true?$setting->getCurrentYearTiendasColor():$setting->getLastYearTiendasColor();
           // print_r($color);die;
           // return $color;
            break;


            case 'nr':
            $color=$currentYear==true?$setting->getCurrentYearNetRevenueColor():$setting->getLastYearNetRevenueColor();
           // print_r($color);die;
           // return $color;
            break;


            case 'fc':
            $color=$currentYear==true?$setting->getCurrentYearForecastColor():$setting->getLastYearForecastColor();
           // print_r($color);die;
           // return $color;
            break;


            case 'nr_vs_ly':
            $color=$currentYear==true?$setting->getCurrentYearNrVsLyColor():$setting->getLastYearNetRevenueColor();
           // print_r($color);die;
           // return $color;
            break;


            
            default:
            $color=$currentYear==true?$setting->getCurrentYearBgcolor():$setting->getPreviousYearBgcolor();
           // return $color;
            break;
        }
        return $color;
    }

       /**
    * 
    * @Annotations\Get("api/grid/data/exporMethod",name="get_data_export_method")
    * @Annotations\View(serializerGroups={
    *   "gride_component","show_activity","get_shops"
    * })
    
    */
    public function getExportMethod()
    {
         $ex = $this->get('phpexcel')->createPHPExcelObject();
         $phpExcelObjectpro = $ex->getProperties();
         $phpExcelObjectIndex=$ex->setActiveSheetIndex(0);
        // $phpExcelObjectIndexvv= $phpExcelObjectIndex->getActiveSheet();
         $x=get_class_methods($phpExcelObjectpro);
         $y=get_class_methods($ex);
         $z=get_class_methods($phpExcelObjectIndex);
         
         $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
         $phpExcelObject->setActiveSheetIndex(0);
         $v=get_class_methods($phpExcelObject->getActiveSheet()->getStyle()->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID));
        // $v=$phpExcelObjectIndex->getDocComment();
         dump($v);die;
    }

    
    /**
    * 
    * @Annotations\Get("api/exporTest",name="get_data_export2_xx")
    * @Annotations\View(serializerGroups={
    *   "gride_component","show_activity","get_shops"
    * })
    
    */
    public function getExport()
    {


        //ask the service for a excel object
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $row_count=5;

        $phpExcelObject->setActiveSheetIndex(0);
        foreach ($variable as $key => $value)
         {
            $phpExcelObject->getActiveSheet()->setCellValue('A9', 'airWix');
            $phpExcelObject->getActiveSheet()->setCellValue('A30', 'duex!');
            $phpExcelObject->getActiveSheet()->mergeCells('A9:A29');
         }
      

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       // $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'PhpExcelFileSample.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }

    public function FunctionName(Type $var = null)
    {
    
    }
  



  
}
