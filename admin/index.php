<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
 
/*-----------引入檔案區--------------*/
//樣版
$xoopsOption['template_main'] = "e_stud_index_adm_tpl.html";
include_once "header_admin.php";

include_once "header.php";

/*-----------function區--------------*/
//
    //取得現在學年
    $c_year = date("Y") -1911 ;
    if  (date("m")<8) $c_year-=1 ;
    //匯出錯誤訊息
    $message='' ;


//匯入判別
function import_stud(){
	if ($_FILES['userdata']['name'] ) {
		 
		$file_up = XOOPS_ROOT_PATH."/uploads/" .$_FILES['userdata']['name'] ;
		copy($_FILES['userdata']['tmp_name'] , $file_up );	
		$main="開始匯入" . $file_up .'<br>';

		//副檔名
		$file_array= preg_split('/[.]/', $_FILES['userdata']['name'] ) ;
		$ext= strtoupper(array_pop($file_array)) ;
		if ($ext=='XML')  
			import_xml($file_up) ;
		if ($ext=='XLS') 
			import_excel($file_up) ;	
		if ($ext=='XLSX') 
			import_excel($file_up , 2007) ;			
		//刪除上傳的檔。
		unlink($file_up)  ;
		
		//把整資料庫中的資料匯整成記錄
		do_statistics() ;
		//redirect_header($_SERVER['PHP_SELF'],3, '資料寫入!' );
	}
	
	return $main; 
 
}

//xml 格式
function import_xml($file_up){
	global $xoopsDB,$c_year , $message ,$xoopsModuleConfig  ;
	
	$emp_stud_id_set = $xoopsModuleConfig['es_stud_sit_id']  ;

	
	//清空學資料庫中學生資料
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("e_student")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

   	//讀入 XML 檔案
 	$xmlDoc = new DOMDocument();
 	$xmlDoc->load( $file_up );
	$x = $xmlDoc->documentElement;
 

	foreach ($x->childNodes AS $y)
	{ 
	 	if ($y->nodeName <>'#text') {
 
			foreach ($y->childNodes AS $item)  {
				if ($item->nodeName <>'#text') {
 
					$user[$item->nodeName] =$item->nodeValue ;

					$stud_person_id = $user[ "身份證字號"] ;
					$stud_name =  $user["姓名"] ;
					$stud_sex =  $user["性別"] ;
					
					$stud_year = $c_year +1  -  $user["入學年"];
 					$stud_class = $user["班級"] ;
 					$stud_class_id  = $stud_year*100 + $stud_class ;
 					$stud_class_id  =  sprintf("%03d" ,$stud_class_id) ;
 					$stud_dom='' ;
					$stud_dom =addslashes( $user["監護人"] );
					
					$stud_sit = $user["座號"] ;
					$stud_birthday = $user["生日_x0028_西元_x0029_"] ;
					$stud_tn_id = $user["代號"] ;
				} 
				

			}
			//$main .= "$stud_person_id $stud_name  $stud_year $stud_dom  $stud_class $stud_sit $stud_birthday  <br/>" ;
 			//如果無座號(預設35號
 			if (intval($stud_sit) == 0) {
 				$stud_sit=$emp_stud_id_set ;
 				$message .= $stud_class_id . $stud_name ." , 座號指定為 $emp_stud_id_set 號($stud_person_id) <br />" ;
			}	
 			//無入學年，視為一年級
 			if (intval($user["入學年"]) == 0) {
 				$stud_year =1 ;
 				$stud_class_id  = $stud_year*100 + $stud_class ;
 				$stud_class_id  =  sprintf("%03d" ,$stud_class_id) ; 				
 				$message .= $stud_class_id . $stud_name ."未設定入學年(尚未指定學號所致?)($stud_person_id) <br />" ;
			}
			
			$sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") . 
			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex ) 			        
			            VALUES ('' , '$stud_tn_id' , '$stud_name' , '$stud_person_id' , '$stud_birthday' , '$stud_class_id' , '$stud_sit' , '$stud_dom' , now() , '$stud_tn_id'  ,'$stud_sex' ) " ;	   	
 
			$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
 
		}
		
	} 	
	

}

//excel 格式
function import_excel($file_up,$ver=5) {
    global $xoopsDB,$c_year;

	//清空學資料庫中學生資料
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("e_student")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	



	include_once '../../tadtools/PHPExcel/IOFactory.php';
	if ($ver ==5)
		$reader = PHPExcel_IOFactory::createReader('Excel5');
	else 	
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
	
	$PHPExcel = $reader->load( $file_up ); // 檔案名稱
	$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
	$highestRow = $sheet->getHighestRow(); // 取得總列數
 
	// 一次讀取一列
	for ($row = 2; $row <= $highestRow; $row++) {
		$v="";
		//讀取一列中的每一格
		for ($col = 0; $col <= 15; $col++) {
			if ($col==6)
				//生日
				$val = PHPExcel_Shared_Date::ExcelToPHPObject( $sheet->getCellByColumnAndRow( $col , $row )->getValue())->format('Y-m-d');
			else 
				$val =  $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
		 /*
			//格式檢查(這部份有問題
			if( PHPExcel_Shared_Date::isDateTime( $sheet->getCellByColumnAndRow($col , $row ) )){
				$val = PHPExcel_Shared_Date::ExcelToPHPObject( $sheet->getCellByColumnAndRow( $col , $row )->getValue())->format('Y-m-d');
			}else{
				//$val =  $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
				$val =  $sheet->getCellByColumnAndRow($col, $row)->getValue() ;
			}
 		*/
			if(!get_magic_quotes_runtime()) {
				$v[$col]=addSlashes($val);
			}else{
				$v[$col]= $val ;
			}
			$stud_year = $c_year +1  -  $v[3] ; 	//入學年計算
			$class_id  =  $stud_year*100 + $v[4] ;	//班級
			$class_id  =  sprintf("%03d" ,$class_id) ;
 
		}
 
			$sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") . 
			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex ) 			        
			            VALUES ('' , '{$v[15]}' , '{$v[1]}' , '{$v[0]}' , '{$v[6]}' , '$class_id' , '{$v[5]}' , '{$v[10]}' , now() , '{$v[15]}'  ,'{$v[2]}' ) " ;	   	
 
			$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	}

}

/*-----------執行動作判斷區----------*/
$op = empty($_REQUEST['op'])? "":$_REQUEST['op'];


switch($op){
	/*---判斷動作請貼在下方---*/
	
	case "import":

	$main=import_stud() ;
	//break;
}

	//取得目前學生資料總計
	$sql=  "select count(*) as students ,  chk_date  from  " . $xoopsDB->prefix("e_student")  ;	   	
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	$data_list=$xoopsDB->fetchArray($result) ;
 
	//取得記錄檔十筆
	$sql=  " select id , rec_time   from  " . $xoopsDB->prefix("es_log")  ."  order by rec_time DESC  ";	   	
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	while($row=$xoopsDB->fetchArray($result)){
		$recdata[]= $row ;
	}


/*-----------秀出結果區--------------*/
 	$xoopsTpl->assign( "data_list" , $data_list ) ; 
 	$xoopsTpl->assign( "recdata" , $recdata ) ; 
 	$xoopsTpl->assign( "c_year" , $c_year ) ; 
 	$xoopsTpl->assign( "message" , $message ) ; 
include_once 'footer.php';

?>