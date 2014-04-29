<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/

//樣版
$xoopsOption['template_main'] = "e_stud_web_tpl.html";
include_once "header_admin.php";

include_once "header.php";

/*-----------function區--------------*/
// is_safe_chk()  ;	//檢查是否訪客有權限

/*-----------執行動作判斷區----------*/
//$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];

//取得班級列表
	$sql =  "  SELECT `class_id`  FROM " . $xoopsDB->prefix("e_student") .  "  GROUP BY `class_id`  ORDER BY  `class_id`  " ;
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($list_class_id=$xoopsDB->fetchArray($result)){
		$data['class_id_list'][$list_class_id['class_id']]= $list_class_id['class_id'] ;
		$tmp_id = $list_class_id['class_id'] ;
		
	}		
	
	//$begstr = "<a href='play.php?flv=$class_id/$sitid.flv&name=$stud_name&class=$class_name target='stud' >$sitid.$stud </a> " ; 
	$string = 'The quick brown fox jumped over the lazy dog.';
	$patterns = array();
	$patterns[0] = '/__class_id/';
	$patterns[1] = '/__sitid/';
	$patterns[2] = '/__name/';
 
 
	
//取得該班的資料
	if  ($_POST['class_id']) 
		$data['select_class_id'] = $_POST['class_id']  ;
	else 
		$data['select_class_id'] =$tmp_id   ;
		
	if ($_POST['tpl']) 
		$tpl_str =$_POST['tpl'];
	else 	
		$tpl_str ="<a href='play.php?flv=__class_id/__sitid.flv&name=__name&class=__class_id' target='web' >__sitid.__name</a>"  ;
				
	if  ( $data['select_class_id']  ) {
		$c_id = $data['select_class_id'] ;
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$c_id'   ORDER BY  `class_sit_num`  " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($stud=$xoopsDB->fetchArray($result)){
			/*
			$students[]=$stud ;
			$class_id= $stud['class_id'] ;
			$stud_name= $stud['name'] ;
			$sitid= $stud['class_sit_num'] ;
			$begstr = "<a href='play.php?flv=$class_id/$sitid.flv&name=$stud_name&class=$class_id' target='web' >$sitid.$stud_name </a> " ; 
			*/
			$replacements = array();
			$replacements[0] = $stud['class_id'] ;
			$replacements[1] =$stud['class_sit_num'] ;
			$replacements[2] =  $stud['name'] ;


			$begstr = preg_replace($patterns, $replacements, $tpl_str);				
				//$begstr =stripslashes($_POST['tpl'] );
			$table_html[]=stripslashes( "<td>$begstr</td>");
 
		}		
	}		
	
	$sexstr= array(1=>'男' ,2=>'女') ;
	

 	$main = "<table width = '80%' border=1 align='center'>\n<tr>\n" ;
 	$i = 0 ;
 	foreach (	    $table_html as $k =>$v) {
		$i++ ;
        	if (($i % 4 )==0 )  {
           		$main .= "$v\n</tr>\n<tr>\n" ;
        	} else 
        		$main .="$v\n" ;
 	}	
	if (($i % 4 )<>0 ) {
		$main .="</tr>\n" ;
   	}	 
   	$main .= "</table>\n" ;
 
/*-----------秀出結果區--------------*/


$xoopsTpl->assign( "data" , $data ) ;
$xoopsTpl->assign( "sexstr" , $sexstr ) ;
$xoopsTpl->assign( "students" , $students ) ; 
$xoopsTpl->assign( "main" , $main ) ;
include_once 'footer.php';


?>