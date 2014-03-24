<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";

/*-----------function區--------------*/
//
function f1(){
	global $xoopsDB;
	//取得目前學生資料
	$sql=  "select count(*) as students ,  chk_date  from  " . $xoopsDB->prefix("e_student")  ;	   	
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	while($data_list=$xoopsDB->fetchArray($result)){
 		$main = '現在學生數：' . $data_list['students']  . ' 人，最近建制日期： ' .  $data_list['chk_date']  ;
	} 	
	
	
/*
	$y = date("Y") -1911 ;
	if  (date("m")<8) $y-=1 ;
*/
	$main .="
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
		<fieldset>
		<legend>台南市學生資料檔案匯入</legend>
		<p><label>由學籍學生基本資料匯出至健康系統，取得全校資料。</label></p>
 		<label>XML檔案</label>
		<input type=file name=userdata><br/>
		<input type='hidden' name='op' value='import'>
		<button type='submit'  name='do_key' class='btn btn-primary'>同步</button>(  XML 要全校名單，舊學生名冊會先全部清除！)
		</fieldset>
		</form>" ;
		
		
 
  return $main;
}

//
function import_stud(){
	global $xoopsDB;
	
	define("_FILES_XML",XOOPS_ROOT_PATH."/uploads/" ."stud.xml");
	$main="開始匯入" . _FILES_XML .'<br>';
 
	copy($_FILES['userdata']['tmp_name'] , _FILES_XML );		
	
	//清空學資料庫中學生資料
	$sql= "TRUNCATE TABLE   " . $xoopsDB->prefix("e_student")  ;
	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	
	//$c_year = $_POST['current_y'] ;
	//取得現在學年
	$c_year = date("Y") -1911 ;
	if  (date("m")<8) $c_year-=1 ;	
	
	
   	//讀入 XML 檔案
 	$xmlDoc = new DOMDocument();
 	$xmlDoc->load( _FILES_XML );
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
					$stud_dom =addslashes( $user["監護人"] );
					
					$stud_sit = $user["座號"] ;
					$stud_birthday = $user["生日_x0028_西元_x0029_"] ;
					$stud_tn_id = $user["代號"] ;
				} 
				

			}
			//$main .= "$stud_person_id $stud_name  $stud_year $stud_dom  $stud_class $stud_sit $stud_birthday  <br/>" ;
 
			$sql=  "INSERT INTO " . $xoopsDB->prefix("e_student") . 
			           "  (`id`, `stud_id`, `name`, `person_id`, `birthday`, `class_id`, `class_sit_num`, `parent`, `chk_date`, `tn_id` ,sex ) 			        
			            VALUES ('' , '$stud_tn_id' , '$stud_name' , '$stud_person_id' , '$stud_birthday' , '$stud_class_id' , '$stud_sit' , '$stud_dom' , now() , '$stud_tn_id'  ,'$stud_sex' ) " ;	   	
 
			$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
 
		}
		
	} 	
	
	//刪除上傳的 XML 檔。
	unlink(_FILES_XML)  ;
 
	redirect_header($_SERVER['PHP_SELF'],3, '資料寫入!' );
	
	return $main;
}


/*-----------執行動作判斷區----------*/
$op = empty($_REQUEST['op'])? "":$_REQUEST['op'];


switch($op){
	/*---判斷動作請貼在下方---*/
	
	case "import":
	$main=import_stud() ;
	//header("location: {$_SERVER['PHP_SELF']}");
	break;

	default:
	$main=f1();
	break;
	
	/*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
module_admin_footer($main,0);

?>