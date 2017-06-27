<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-07-20
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once "../function.php";

include_once "../../tadtools/PHPExcel.php";
require_once '../../tadtools/PHPExcel/IOFactory.php';
/*-----------function區--------------*/


/*-----------執行動作判斷區----------*/
  //班級名稱
  $class_name_list_c=es_class_name_list_c('long')   ;

 //校內教師群組代號
	$teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;
 //教師名冊
 	$teacher= get_teacher_list($teach_group_id) ;

//取得班級列表
 	$sql =  "  SELECT  class_id  FROM  " . $xoopsDB->prefix("e_student") .  "    group by class_id order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_list[$data_row['class_id']]= $data_row['class_id'] ;
 	 	//依年級作分組
 	 	$g=substr($data_row['class_id'],0,1) ;
 	 	$g_class_list[$g][$data_row['class_id']]= $data_row['class_id'] ;
	}


	//班級人數統計
	$sql = " SELECT class_id, sex , count( * ) cc FROM " . $xoopsDB->prefix("e_student") . " GROUP BY class_id , sex order by class_id, sex  " ;
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());
	while($row=$xoopsDB->fetchArray($result)){
		$class_id= $row['class_id'] ;
		$sex= $row['sex'] ;
		$class_sex[$class_id][$sex]= $row['cc'];
		$class_sum[$class_id] +=$row['cc'];
	}

//取得已指定的級任代號
	$sql =  "  SELECT  *  FROM  " . $xoopsDB->prefix("e_classteacher") .  "    order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_teach[$data_row['class_id']]= $teacher[$data_row['uid']]['name'] ;
	}


	//----------------------------------------------------------------------------------
 	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);  //設定預設顯示的工作表
	$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
	$objActSheet->setTitle("班級統計表");  //設定標題
  	//設定框線
	$objBorder=$objActSheet->getDefaultStyle()->getBorders();
	$objBorder->getBottom()
          	->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
          	->getColor()->setRGB('000000');
	$objActSheet->getDefaultRowDimension()->setRowHeight(15);


	$row= 1 ;
       //標題行
      	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, '時間：' . date("Y-m-d")  );
       	$col ='A' ;
	//行高
	$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(34);
       	//列寬
      	// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('10');


     //資料區
     foreach ( $g_class_list  as $grade => $class_array )  {
			$row++ ;
			//行高
			//$objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(34);
 			$col ='A' ;
			 foreach ($class_array as $k =>$class_id ) {

				$col_str =$col .$row ;

				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $class_name_list_c[$class_id]) ;
				//下行級任
				$col_str =$col .($row+1) ;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $class_teach[$class_id]) ;
				//下行人數
				$col_str =$col .($row+2) ;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , $class_sum[$class_id].'人' ) ;
				//下行男女人數
				$col_str =$col .($row+3) ;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_str , '(' .$class_sex[$class_id][1].' ,'.  $class_sex[$class_id][2] .')' ) ;

				$col++ ;

			}
			$row= $row+5 ;
		}


    //header('Content-Type: application/vnd.ms-excel');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename=class_'.date("mdHi").'.xlsx' );
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//暫存區內容先清空
	ob_clean();
	$objWriter->save('php://output');
	exit;


?>
