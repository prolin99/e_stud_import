<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版

$xoopsOption['template_main'] = "e_stud_adm_main.tpl";
include_once "header.php";
include_once "../function.php";

require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'; //引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php'; //引入PHPExcel_IOFactory 物件庫

/*-----------function區--------------*/
//
    //取得現在學年
    $c_year = date("Y") -1911 ;
    if  (date("m")<8) $c_year-=1 ;
    //匯出錯誤訊息
    $message='' ;

//更新特定班學生偏好
function udList_set(){
    global $xoopsDB ;
    if ($_POST['updnlist']){
        $myts =& MyTextSanitizer::getInstance();
    	$list = $myts->htmlspecialchars($myts->addSlashes($_POST['updnlist'])) ;

        $sql=  " update   " . $xoopsDB->prefix("config") ." set conf_value='{$list}' where conf_name='es_stud_stud_dn'  "  ;
        $result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
        redirect_header($_SERVER['PHP_SELF']) ;
    }
}

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
		//if ($ext=='XLS')
		//	import_excel($file_up) ;
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

//要降轉的學生 ，傳出 身份証=降昇、指定班
function stud_dn_list(){
    global $xoopsModuleConfig ;

    $stud_dn = $xoopsModuleConfig['es_stud_stud_dn']  ;
    $list=preg_split('/[-\n]/' , $stud_dn) ;
    for ($i=0; $i<=count($list); $i=$i+3)
        if ($list[$i])
            $stud_dn_list[trim($list[$i])]=strtoupper(trim($list[$i+2]));

    return $stud_dn_list ;
}
//xml 格式
function import_xml($file_up){
	global $xoopsDB,$c_year , $message ,$xoopsModuleConfig  ,$xoopsTpl;

	$emp_stud_id_set = $xoopsModuleConfig['es_stud_sit_id']  ;

    $dn_list = stud_dn_list() ;

	//清空學資料庫中學生資料
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("e_student")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());

   	//讀入 XML 檔案
 	$xmlDoc = new DOMDocument();
 	$xmlDoc->load( $file_up );
	$x = $xmlDoc->documentElement;


	foreach ($x->childNodes AS $y)
	{
        //監護人資料先清空，因為有可能缺值
        $user["監護人"]='' ;
        $user["父親姓名"]='' ;

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
                    $stud_father='' ;
                    $stud_father =addslashes( $user["父親姓名"] );
 					$stud_dom='' ;
					$stud_dom =addslashes( $user["監護人"] );
                    if   ($stud_dom =='' )
						$stud_dom =  $stud_father ;

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

 			if (intval($stud_tn_id) == 0) {
 				$message .= $stud_class_id . $stud_name ." , 沒有指定代號(學號)資料<br />" ;
			}

 			//無入學年，視為一年級
 			if (intval($user["入學年"]) == 0) {
 				$stud_year =1 ;
 				$stud_class_id  = $stud_year*100 + $stud_class ;
 				$stud_class_id  =  sprintf("%03d" ,$stud_class_id) ;
 				$message .= $stud_class_id . $stud_name ."未設定入學年(尚未指定學號所致?)($stud_person_id) <br />" ;
			}

            //昇降年度、指定班
            if ($dn_list[$stud_person_id] ){
                if (substr($dn_list[$stud_person_id],0,1)=='D')
                    $stud_year = $stud_year - substr($dn_list[$stud_person_id],1) ;
                if (substr($dn_list[$stud_person_id],0,1)=='U')
                    $stud_year = $stud_year + substr($dn_list[$stud_person_id],1) ;

                $stud_class_id  = $stud_year*100 + $stud_class ;
                $stud_class_id  =  sprintf("%03d" ,$stud_class_id) ;
                if ($dn_list[$stud_person_id] > 100)
                    $stud_class_id  =  sprintf("%03d" ,$dn_list[$stud_person_id]) ;
                $message .=  $stud_name ." ,指定為 {$stud_class_id} 班 ($stud_person_id)  <br />" ;
            }

            if ( $xoopsModuleConfig['es_stud_deny_personid']){
                //$stud_person_id='null' ;
                //$stud_birthday='null' ;
                $sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") .
                       "  (`id`, `stud_id`, `name`, `person_id`, `birthday`,  `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex )
                        VALUES ('0' , '$stud_tn_id' , '$stud_name' , '' , null,   '$stud_class_id' , '$stud_sit' , '$stud_dom' , now() , '$stud_tn_id'  ,'$stud_sex' ) " ;

            }else{
	            $sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") .
			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex )
			            VALUES ('0' , '$stud_tn_id' , '$stud_name' , '$stud_person_id' , '$stud_birthday' , '$stud_class_id' , '$stud_sit' , '$stud_dom' , now() , '$stud_tn_id'  ,'$stud_sex' ) " ;
            }

			$result = $xoopsDB->query($sql)  ;
            if ($xoopsDB->error() ) {
                 echo  $xoopsDB->error() . $sql ."<br />" ;
            }


		}

	}

	//$xoopsTpl->assign( "message" , $message ) ;
}

//excel 格式
function import_excel($file_up,$ver=2007) {
    global $xoopsDB,$c_year ,$xoopsTpl ,$message ;

    $dn_list = stud_dn_list() ;

	//清空學資料庫中學生資料
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("e_student")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());



	//include_once '../../tadtools/PHPExcel/IOFactory.php';
    /*
	if ($ver ==5)
		$reader = PHPExcel_IOFactory::createReader('Excel5');
	else
    */
	$reader = PHPExcel_IOFactory::createReader('Excel2007');

	$PHPExcel = $reader->load( $file_up ); // 檔案名稱
	$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
	//$highestRow = $sheet->getHighestRow(); // 取得總列數
    $maxCell = $PHPExcel->getActiveSheet()->getHighestRowAndColumn();
    $highestRow = $maxCell['row'] ;

	// 一次讀取一列
	for ($row = 2; $row <= $highestRow; $row++) {
		$v=array();
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

		}

		if ($v[1]){
			$stud_year = $c_year +1  -  $v[3] ; 	//入學年計算

			$class_id  =  $stud_year*100 + $v[4] ;	//班級
			$class_id  =  sprintf("%03d" ,$class_id) ;

 			//無入學年，視為一年級
 			if (intval($v[3]) == 0) {
 				$stud_year =1 ;
 				$stud_class_id  = $stud_year*100 + $v[4] ;
 				$class_id  =  sprintf("%03d" ,$stud_class_id) ;
 				$message .= $class_id . $v[1] ."未設定入學年({$v[0]}) <br />" ;
			}

  			if (intval($v[15]) == 0) {
 				$message .= $class_id . $v[1] ." , 沒有指定代號(學號)資料<br />" ;
			}

            //昇降年度、指定班
            if ($dn_list[$stud_person_id] ){
                if (substr($dn_list[$stud_person_id],0,1)=='D')
                    $stud_year = $stud_year - substr($dn_list[$stud_person_id],1) ;
                if (substr($dn_list[$stud_person_id],0,1)=='U')
                    $stud_year = $stud_year + substr($dn_list[$stud_person_id],1) ;

                $stud_class_id  = $stud_year*100 +  $v[4] ;
                $class_id  =  sprintf("%03d" ,$stud_class_id) ;
                if ($dn_list[$stud_person_id] > 100)
                    $class_id  =  sprintf("%03d" ,$dn_list[$stud_person_id]) ;
                $message .=  $stud_name ." ,指定為 {$class_id} 班 ($stud_person_id)  <br />" ;
            }

            if ( $xoopsModuleConfig['es_stud_deny_personid']){
                $v[0]='' ;
                $v[6]='' ;
                $sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") .
    			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex )
    			            VALUES ('0' , '{$v[15]}' , '{$v[1]}' , '{$v[0]}' , null , '$class_id' , '{$v[5]}' , '{$v[10]}' , now() , '{$v[15]}'  ,'{$v[2]}' ) " ;
            }else{
                $sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") .
    			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex )
    			            VALUES ('0' , '{$v[15]}' , '{$v[1]}' , '{$v[0]}' , '{$v[6]}' , '$class_id' , '{$v[5]}' , '{$v[10]}' , now() , '{$v[15]}'  ,'{$v[2]}' ) " ;
            }

            //echo "$sql <br>" ;
			$result = $xoopsDB->query($sql) ;
            if ($xoopsDB->error() ) {
                 echo  $xoopsDB->error() . $sql ."<br />" ;
            }
		}
	}


}

/*-----------執行動作判斷區----------*/
$op = empty($_REQUEST['op'])? "":$_REQUEST['op'];


switch($op){
	/*---判斷動作請貼在下方---*/

	case "import":
    	$main=import_stud() ;
	break;

    case "UpDnListSet":
    	$main=udList_set() ;
	break;
}

	//取得目前學生總人數
	$sql=  "select count(*) as students  from  " . $xoopsDB->prefix("e_student")  ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	$data_list=$xoopsDB->fetchArray($result) ;

	//取得記錄檔十筆
	$sql=  " select id , rec_time   from  " . $xoopsDB->prefix("es_log")  ."  where   module='e_stud_import' order by rec_time DESC  ";
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	while($row=$xoopsDB->fetchArray($result)){
		$recdata[]= $row ;
	}


/*-----------秀出結果區--------------*/
 	$xoopsTpl->assign( "data_list" , $data_list ) ;
 	$xoopsTpl->assign( "recdata" , $recdata ) ;
 	$xoopsTpl->assign( "c_year" , $c_year ) ;
 	$xoopsTpl->assign( "message" , $message ) ;
    $xoopsTpl->assign( "es_stud_stud_dn" , $xoopsModuleConfig['es_stud_stud_dn'])  ;
include_once 'footer.php';

?>
