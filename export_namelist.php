<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-07-20
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once XOOPS_ROOT_PATH."/header.php";

include_once "../tadtools/PHPExcel.php";
require_once '../tadtools/PHPExcel/IOFactory.php';    
/*-----------function區--------------*/
 if (!$xoopsUser) 
  	redirect_header(XOOPS_URL,3, "需要登入，才能使用！");
  	
  //校內教師群組代號
  $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;
 
if (! in_array(   $teach_group_id , $xoopsUser->groups() )  ) 
  	redirect_header(XOOPS_URL,3, "教職員，才能使用！");
	

/*-----------執行動作判斷區----------*/
  //班級名稱
  $class_name_list_c=es_class_name_list_c('long')   ;


$grade = intval($_GET['grade'] ) ;
$class_id = intval($_GET['class_id'] ) ;
if  ($grade==1) {
	$g = substr($class_id ,0,1) ;
	$sql =  "  SELECT class_id , class_sit_num ,name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id  like '$g%'  ORDER BY  class_id , class_sit_num  " ;
}else {	
	if ($class_id >0 ) {
		$sql =  "  SELECT class_id , class_sit_num ,name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id  = '$class_id'  ORDER BY  class_id , class_sit_num  " ;
	}	else 
		exit  ;
}		
//echo $sql ;
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($stud=$xoopsDB->fetchArray($result)){
			$data[]=$stud ;
		}		
 

	//----------------------------------------------------------------------------------
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);  //設定預設顯示的工作表
	$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
	$objActSheet->setTitle("班級名冊");  //設定標題	
  	//設定框線
  	
	$objBorder=$objActSheet->getDefaultStyle()->getBorders();
	//$objBorder->getBottom()
	$objBorder->getBottom()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000'); 
	$objBorder->getLeft()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000'); 
	$objBorder->getRight()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000'); 
 	$objBorder->getTop()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000');          	
	$objActSheet->getDefaultRowDimension()->setRowHeight(15);

	
	$row= 0 ;

       $col ='A' ;
		//行高
		//	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(34);       
       //列寬
       // $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');

      
     //資料區
     foreach ( $data  as $id => $stud )  {
		if  ($now_class<>$stud['class_id'] ) {
			if ($row>1)  $objPHPExcel->getActiveSheet()->setBreak( 'A' . $row, PHPExcel_Worksheet::BREAK_ROW );			//分頁
			$row++ ;
			//標題行
			$objPHPExcel->setActiveSheetIndex(0) 
				->setCellValue('A'.$row , '班級'  );
			$objPHPExcel->setActiveSheetIndex(0) 
				->setCellValue('B'.$row , '座號'  );
			$objPHPExcel->setActiveSheetIndex(0) 
				->setCellValue('C'.$row , '姓名'  );   
				
			$col ='C' ;	
			for ($i =1 ; $i<=6 ; $i++)  {
				$col++ ;
				$col_str =$col .$row ;
				$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue($col_str , $i  );        				
			}
		
				//$row++ ;
				$now_class=$stud['class_id']  ;
		}
			$row++ ;
			//行高
			//$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(34);
 			$col ='A' ;
			$col_str =$col .$row ;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $class_name_list_c[$stud['class_id']] ) ;
			$col++ ;
			$col_str =$col .$row ;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $stud['class_sit_num'] ) ;			
			$col++ ;
			$col_str =$col .$row ;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $stud['name'] ) ;			
		}	
/*		
$styleThinBlackBorderOutline = array(
       'borders' => array (
             'outline' => array (
                   'style' => PHPExcel_Style_Border::BORDER_THIN,   //設置border样式
                   //'style' => PHPExcel_Style_Border::BORDER_THICK,  另一種样式
                   'color' => array ('argb' => 'FF000000'),          //設置border顏色
            ),
      ),
);
$objPHPExcel->getActiveSheet()->getStyle( 'A1:M'.$row)->applyFromArray($styleThinBlackBorderOutline);
*/                   
 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename=class_'.date("mdHi").'.xlsx' );
	header('Cache-Control: max-age=0');

	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//暫存區內容先清空
	ob_clean();
	$objWriter->save('php://output');
	exit;		
 
 
?>