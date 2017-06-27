<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-09-01
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";


include_once "../tadtools/PHPWord.php";

/*-----------function區--------------*/
if (!$xoopsUser)
  	redirect_header(XOOPS_URL,3, "需要登入，才能使用！");

//校內教師群組代號
$teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;

if (! in_array(   $teach_group_id , $xoopsUser->groups() )  )
  	redirect_header(XOOPS_URL,3, "教職員，才能使用！");

$show_doc = $xoopsModuleConfig['es_stud_parent_doc']  ;


/*-----------執行動作判斷區----------*/
//班級名稱
$class_name_list_c=es_class_name_list_c('long')   ;



$class_id = intval($_GET['class_id'] ) ;

if ($class_id >0 ) {
	$sql =  "  SELECT class_id , class_sit_num ,name , parent  FROM " . $xoopsDB->prefix("e_student") . "   where class_id  = '$class_id'  ORDER BY  class_id , class_sit_num  " ;
}else
	exit  ;

$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
while($stud=$xoopsDB->fetchArray($result)){
  //空號不影響
  $class_sit_order++ ;
	$data[$class_sit_order]=$stud ;
	//$data[]=$stud ;
}

	$PHPWord = new PHPWord();


 	$PHPWord->setDefaultFontName('標楷體'); //設定預設字型
	$PHPWord->setDefaultFontSize(14);     //設定預設字型大小

/*
	$sectionStyle = array('orientation' => null,  'marginLeft' => 900); //頁面設定（orientation 的值可以是橫向landscape或直向portrait。設定項目有：orientation、marginTop、marginLeft、marginRight、marginBottom、borderTopSize、borderTopColor、borderLeftSize、borderLeftColor、borderRightSize、borderRightColor、borderBottomSize、borderBottomColor）
	$section = $PHPWord->createSection($sectionStyle); //建立一個頁面
*/
	$section = $PHPWord->createSection(); //建立一個頁面
	$styleFont_h1 = array('name'=>'Tahoma',  'size'=>24, 'bold'=>true);
	$styleParagraph_h1 = array('align'=>'center', 'spaceAfter'=>100);
	$styleFont_h2 = array('name'=>'Tahoma',  'size'=>18, 'bold'=>true);
	$styleParagraph_h2 = array('align'=>'center', 'spaceAfter'=>100);
	//內容格
	$style_cell = array('align'=>'center');
	$styleFont_cell =  array('name'=>'Tahoma',  'size'=>14);
	$styleFont_cell_red =  array('name'=>'Tahoma',  'size'=>14 ,  'color'=>'red');

	//
	$cellStyle = array(	 'bgColor'=>'FFFFFF','valign'=>'center');
	//cell 字型

	$styleFont_cell_top =  array('name'=>'Tahoma',  'size'=>14 , 'bold'=>true);
	$style_cell_top = array('align'=>'center');

    //表格框線
	$styleTable = array('borderColor'=>'000000', 'borderSize'=>2, 'cellMargin'=>50); //表格樣式（可用設定：cellMarginTop、cellMarginLeft、cellMarginRight、cellMarginBottom、cellMargin、bgColor、 borderTopSize、borderTopColor、borderLeftSize、borderLeftColor、borderRightSize、borderRightColor、borderBottomSize、borderBottomColor、borderInsideHSize、borderInsideHColor、borderInsideVSize、borderInsideVColor、borderSize、borderColor）
	$styleFirstRow = array('bgColor'=>'FFFFFF'); //首行樣式

	$page =0 ;

	//標題處
	$section->addText( $class_name_list_c[$class_id] . ' 家長代表圈選單', $styleFont_h1,$styleParagraph_h1);

	$PHPWord->addTableStyle('myTable', $styleTable, $styleFirstRow); //建立表格樣式

	//$PHPWord->addTableStyle('myTable' ); //建立表格樣式
	$table = $section->addTable('myTable');//建立表格

	//table title
	$table->addRow(1000); //新增一列

	//$cellStyle =array('textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR, 'bgColor'=>'C0C0C0'); //儲存格樣式（設定項：valign、textDirection、bgColor、borderTopSize、borderTopColor、borderLeftSize、borderLeftColor、borderRightSize、borderRightColor、borderBottomSize、borderBottomColor）

	$table->addCell(2000,$cellStyle )->addText('圈選處',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(1000,$cellStyle )->addText('座號',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(2000,$cellStyle )->addText('學生',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(2000,$cellStyle )->addText('家長',$styleFont_cell_top ,$style_cell_top); //新增一格

	$table->addCell(100,$cellStyle )->addText('',$styleFont_cell_top ,$style_cell_top); //新增一格


	$table->addCell(2000,$cellStyle )->addText('圈選處',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(1000,$cellStyle )->addText('座號',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(2000,$cellStyle )->addText('學生',$styleFont_cell_top ,$style_cell_top); //新增一格
	$table->addCell(2000,$cellStyle )->addText('家長',$styleFont_cell_top ,$style_cell_top); //新增一格



 	for ($s=1 ; $s <= 20 ; $s++ )  {
		$table->addRow(); //新增一列
		$table->addCell(2000 )->addText('',$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(1000 )->addText($data[$s]['class_sit_num'],$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(2000 )->addText($data[$s]['name'],$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(2000 )->addText($data[$s]['parent'],$styleFont_cell ,$style_cell); //新增一格
		//echo $data[$s]['class_sit_num'] ;
		$table->addCell(100 )->addText('',$styleFont_cell ,$style_cell); //新增一格

		$table->addCell(2000 )->addText('',$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(1000 )->addText($data[$s+20]['class_sit_num'],$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(2000 )->addText($data[$s+20]['name'],$styleFont_cell ,$style_cell); //新增一格
		$table->addCell(2000)->addText($data[$s+20]['parent'],$styleFont_cell ,$style_cell); //新增一格

	}
 	$section->addText( $show_doc );

  //header('Content-Type: application/vnd.ms-word');
	header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	header('Content-Disposition: attachment;filename=家長代表選單_' . $class_id .'.docx');
	header('Cache-Control: max-age=0');
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	ob_clean();
	$objWriter->save('php://output');
	exit;

?>
