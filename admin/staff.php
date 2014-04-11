<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版
$xoopsOption['template_main'] = "staff_tpl.html";
include_once "header_admin.php";

include_once "header.php";

//清除
if ($_POST['act_clear']) {
	$sql = " TRUNCATE   "  . $xoopsDB->prefix("e_staff") ;
    $result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 	
}	
/*-----------function區--------------*/
//取得職稱
$staff_list  = preg_split('/[\s,\r\n]/' ,$xoopsModuleConfig['es_studs_teacher_job']) ;
foreach ($staff_list as $k=>$v) {
	$staff_job = preg_split('/[-]/' , $v) ;
	$sid= trim($staff_job[0]) ;
	$job= trim($staff_job[1]) ;
	if ($sid and $job )
		$staff[$sid] = $job ;
}	
	$data['staff'] = $staff ;



//取得教師名冊
$teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;

 $sql =  "  SELECT  u.uid, u.name , g.groupid   FROM  " . $xoopsDB->prefix("groups_users_link") .  "  g  ,  " .  $xoopsDB->prefix("users") .  "  u  " . 
 	     "  where g.uid= u.uid and  g.groupid='$teach_group_id'  order by u.name  " ;
 
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$teacher[$data_row['uid']]= $data_row['name'] ;
	}
	$data['class_list'] = $teacher ;
/*	
//取得班級列表
 $sql =  "  SELECT  class_id  FROM  " . $xoopsDB->prefix("e_student") .  "    group by class_id order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_list[$data_row['class_id']]= $data_row['class_id'] ;
	}
	$data['class_list'] = $class_list ;
*/
/*
//取得已指定的級任代號
	$sql =  "  SELECT  *  FROM  " . $xoopsDB->prefix("e_classteacher") .  "    order by class_id  " ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_set[$data_row['class_id']]= $data_row['uid'] ;
 	 	$class_teach[$data_row['class_id']]= $teacher[$data_row['uid']] ;
 	 	$teacher_class[$data_row['uid']]= $data_row['class_id'] ;
	}
 */
	$data['staff_set'] = $class_set ;
	$data['staff_teach'] = $class_teach ;
	$data['teacher_staff'] = $teacher_class ;
	
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "data" , $data ) ; 
 
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;


//include_once XOOPS_ROOT_PATH.'/footer.php';
//module_admin_footer($main,0);
 
include_once 'footer.php';

?>