<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版
$xoopsOption['template_main'] = "e_teacher_tpl.html";
include_once "header_admin.php";

include_once "header.php";

//清除全部級任 ------------------------------------------------------------
if ($_POST['act_clear']) {
	//$sql = " TRUNCATE   "  . $xoopsDB->prefix("e_classteacher") ;
	$sql = " update    "  . $xoopsDB->prefix("e_classteacher")  . " set class_id=''    "  ; ;	
    	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	
    
    	//清空    staff 職稱  級任教師 或 學年主任
	$sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='' where  ( staff  LIKE '%級任%' ) or  (staff   LIKE '%學年主任%' )  "  ;
    	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	    
}	


//135 級任升級 ------------------------------------------------------------
if ($_POST['act_up']) {
	//清除246
	$sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='' where ( 
		( SUBSTR( class_id, 1, 1 )	IN ( 2, 4, 6 ) ) and  
		(  ( staff  LIKE '%級任%' ) or  (staff   LIKE '%學年主任%' ) )
		)"  ;
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	    	
	$sql = "UPDATE  "  . $xoopsDB->prefix("e_classteacher") ." SET `class_id`=''
			WHERE SUBSTR( class_id, 1, 1 )	IN ( 2, 4, 6 )  " ;
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	    		
	
	//升級 135 
	$sql = "UPDATE  "  . $xoopsDB->prefix("e_classteacher") ." SET `class_id`=CONCAT( (SUBSTR( class_id, 1, 1 )+1 ), SUBSTR( class_id, 2, 2 ) )
			WHERE SUBSTR( class_id, 1, 1 ) 			IN ( 1, 3, 5 )  " ;
			
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	    
    


}


/*-----------function區--------------*/

 //校內教師群組代號
	$teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;
	
 //教師名冊
 	$teacher= get_teacher_list($teach_group_id) ;
 	$data['teacher'] = $teacher ;
 
  	//找級任教師 的代號
  	$staff = get_staff_list()	;
  	$data['staff_teacher_id'] = $staff['class_tid'] ;
  
  
//取得班級列表
 	$sql =  "  SELECT  class_id  FROM  " . $xoopsDB->prefix("e_student") .  "    group by class_id order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_list[$data_row['class_id']]= $data_row['class_id'] ;
 	 	//依年級作分組
 	 	$g=substr($data_row['class_id'],0,1) ;
 	 	$g_class_list[$g][$data_row['class_id']]= $data_row['class_id'] ;
	}
	$data['class_list'] = $class_list ;
	$data['g_class_list'] = $g_class_list ;

//取得已指定的級任代號
	$sql =  "  SELECT  *  FROM  " . $xoopsDB->prefix("e_classteacher") .  "    order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_set[$data_row['class_id']]= $data_row['uid'] ;
 	 	$class_teach[$data_row['class_id']]= $teacher[$data_row['uid']]['name'] ;
 	 	$teacher_class[$data_row['uid']]= $data_row['class_id'] ;
	}
	$data['class_set'] = $class_set ;
	$data['class_teach'] = $class_teach ;
	$data['teacher_class'] = $teacher_class ;
	
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "data" , $data ) ; 
 
include_once 'footer.php';

?>