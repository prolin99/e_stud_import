<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
 
/*-----------引入檔案區--------------*/

$xoopsOption['template_main'] = "e_stat_tpl.html";
include_once "header.php";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------function區--------------*/
 if (!$xoopsUser) 
  	redirect_header(XOOPS_URL,3, "需要登入，才能使用！");
  	
  //校內教師群組代號
  $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;
 
if (! in_array(   $teach_group_id , $xoopsUser->groups() )  ) 
  	redirect_header(XOOPS_URL,3, "教職員，才能使用！");


	//取得記錄檔 
	$sql=  " select  message   from  " . $xoopsDB->prefix("es_log")  ."  where module='e_stud_import' order by id DESC  LIMIT 0 , 1  ";	   	
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
	$row=$xoopsDB->fetchArray($result) ;
	$data =  $row['message'] ;
 
	
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "data" , $data ) ;
 
 
include_once XOOPS_ROOT_PATH.'/footer.php';

?>