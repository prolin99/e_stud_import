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

/*-----------執行動作判斷區----------*/
 
  //取回常用樣式
  $tpl_list  = preg_split('/[,\r\n]/' ,$xoopsModuleConfig['es_studs_exweb']) ;
  foreach ($tpl_list as $k =>$v) {
	if (trim($v) ) {
		$tpl_used[]=$v ;
		$tpl_list_show[] = htmlentities($v) ;
	}	
  }

$data['class_name_list_c']=es_class_name_list_c('long')   ;
$tmp_id=key($data['class_name_list_c']) ;

//取得班級列表
/*
	$sql =  "  SELECT `class_id`  FROM " . $xoopsDB->prefix("e_student") .  "  GROUP BY `class_id`  ORDER BY  `class_id`  " ;
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($list_class_id=$xoopsDB->fetchArray($result)){
		$data['class_id_list'][$list_class_id['class_id']]= $list_class_id['class_id'] ;
		$tmp_id = $list_class_id['class_id'] ;
		
	}		
*/	
	//$begstr = "<a href='play.php?flv=$class_id/$sitid.flv&name=$stud_name&class=$class_name target='stud' >$sitid.$stud </a> " ; 
	$string = 'The quick brown fox jumped over the lazy dog.';
	$patterns = array();
	$patterns[0] = '/__class_id/';
	$patterns[1] = '/__sitid/';
	$patterns[2] = '/__name/';
	$patterns[3] = '/__person_id/';
	$patterns[4] = '/__birthday/';
	$patterns[5] = '/__stud_id/';
	$patterns[6] = '/__parent/';
	$patterns[7] = '/__sex/';
	$patterns[8] = '/__nam00/';
	$patterns[9] = '/__paren00/';
	
/*	
__class_id 班級代號
__sitid 座號
__name 學生姓名
__person_id 身份証號
__birthday 生日
__stud_id 學生代號
__parent 學生監護人
__sex 性別代碼
 */
 
	
//取得該班的資料
	if  ($_POST['class_id']) 
		$data['select_class_id'] = $_POST['class_id']  ;
	else 
		$data['select_class_id'] =$tmp_id   ;
		
		
	if ($_POST['tpl']) 
		$tpl_str =$_POST['tpl'];
	else 
		//取出第一個偏好為預設值
		$tpl_str =$tpl_used[0] ; 

	$sexstr= array(1=>'男' ,2=>'女') ;	
				
	if  ( $data['select_class_id']  ) {
		$c_id = $data['select_class_id'] ;
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$c_id'   ORDER BY  `class_sit_num`  " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($stud=$xoopsDB->fetchArray($result)){
 
			$replacements = array();
			$replacements[0] = $stud['class_id'] ;
			$replacements[1] =$stud['class_sit_num'] ;
			$replacements[2] =  $stud['name'] ;
			$replacements[3] =  $stud['person_id'] ;
			$replacements[4] =  $stud['birthday'] ;
			$replacements[5] =  $stud['stud_id'] ;
			$replacements[6] =  $stud['parent'] ;
			$replacements[7] =  $sexstr[$stud['sex']] ;
			$replacements[8] =  mb_substr($stud['name'],0,1,"utf-8").'同學' ;
			$replacements[9] =  mb_substr($stud['parent'] ,0,1,"utf-8").'家長' ;


			$begstr = preg_replace($patterns, $replacements, $tpl_str);				
				//$begstr =stripslashes($_POST['tpl'] );
			$table_html[]=stripslashes( "<td>$begstr</td>");
 
		}		
	}		
	
	
	

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
$xoopsTpl->assign( "tpl_list" , $tpl_list_show ) ;
$xoopsTpl->assign( "tpl_str" , stripslashes($tpl_str) ) ;
include_once 'footer.php';


?>