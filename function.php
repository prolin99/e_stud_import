<?php
//  ------------------------------------------------------------------------ //
// 本模組由 無名氏 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
//引入TadTools的函式庫
if(!file_exists(TADTOOLS_PATH."/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once TADTOOLS_PATH."/tad_function.php";

/********************* 自訂函數 *********************/



/********************* 預設函數 *********************/
//圓角文字框
function div_3d($title="",$main="",$kind="raised",$style="",$other=""){
	$main="<table style='width:auto;{$style}'><tr><td>
	<div class='{$kind}'>
	<h1>$title</h1>
	$other
	<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
	<div class='boxcontent'>
 	$main
	</div>
	<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	</td></tr></table>";
	return $main;
}

//檢查群組權限是否訪客可以查看( true 代表權限設定是 ok，否則提醒) 
function is_safe_chk() {
	global  $xoopsDB , $xoopsModule ;
	//取得目前代號
	$mod_id = $xoopsModule->getVar('mid')  ;
	$mod_name = $xoopsModule->getVar('name', 'n')  ;
 
	
	//檢查訪客、註冊者有無讀取權限，如果有出現訊息提醒
	$sql =  "  SELECT count(*) as cc  FROM " . $xoopsDB->prefix("group_permission") . 
			" where   gperm_itemid =$mod_id and   ( gperm_groupid =". XOOPS_GROUP_ANONYMOUS  ."  or   gperm_groupid =" . XOOPS_GROUP_USERS .")  " ;
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 			
	while($date_list=$xoopsDB->fetchArray($result)){
		$cc = $date_list['cc'] ;
	}
	if ($cc>0) {
		 redirect_header( XOOPS_URL ,3, $mod_name . '模組，使用權限設定不正確，請把訪客、註冊者權限移除');
		return false ;
	}else 	
		return true ;
	
}
?>