<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/


include_once "header.php";
$xoopsOption['template_main'] = "e_stud_index_tpl.html";
include_once XOOPS_ROOT_PATH."/header.php";

/*-----------function區--------------*/
 is_safe_chk()  ;	//檢查是否訪客有權限

/*-----------執行動作判斷區----------*/
$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];

//取得班級列表
	$sql =  "  SELECT `class_id`  FROM " . $xoopsDB->prefix("e_student") .  "  GROUP BY `class_id`  ORDER BY  `class_id`  " ;
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($list_class_id=$xoopsDB->fetchArray($result)){
		$data['class_id_list'][$list_class_id['class_id']]= $list_class_id['class_id'] ;
		$tmp_id = $list_class_id['class_id'] ;
		
	}		
	
 
//取得該班的資料
	if  ($_POST['class_id']) 
		$data['select_class_id'] = $_POST['class_id']  ;
	else 
		$data['select_class_id'] =$tmp_id   ;
	
	if  ( $data['select_class_id']  ) {
		$c_id = $data['select_class_id'] ;
		$sql =  "  SELECT  *  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$c_id'   ORDER BY  `class_sit_num`  " ;
 
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
		while($stud=$xoopsDB->fetchArray($result)){
			$students[]=$stud ;
			
		}		
 
	}		
	
	$sexstr= array(1=>'男' ,2=>'女') ;
 
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "data" , $data ) ;
$xoopsTpl->assign( "sexstr" , $sexstr ) ;
$xoopsTpl->assign( "students" , $students ) ; 
include_once XOOPS_ROOT_PATH.'/footer.php';

?>