<?php
 
include 'header.php';

 //引入XOOPS的權限表單物件檔
 include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
 //取得本模組編號
 
  function xoops_module_install_e_stud_import( $xoopsMod ) {
	global $modversion ;
       if (everythingIsOK) {
 	perm_set($modversion['dirname']	) ;
          return true;
      } else {
          return false;
      }
  }
//建立目錄
function mk_dir($dir=""){
    //若無目錄名稱秀出警告訊息
    if(empty($dir))return;
    //若目錄不存在的話建立目錄
    if (!is_dir($dir)) {
        umask(000);
        //若建立失敗秀出警告訊息
        mkdir($dir, 0777);
    }
}

function perm_set($dirname) {
	global $xoopsDB;
	//取得模組的 ID 
	$sql = " SELECT mid FROM `".$xoopsDB->prefix("modules") ."` WHERE `dirname` = '$dirname' " ;
  	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  	list($mid )=$xoopsDB->fetchRow($result);	
	if ($mid ) {
		//刪除 訪客、註冊者權限
		$sql = "DELETE FROM `". $xoopsDB->prefix("group_permission") . "` WHERE gperm_itemid  =$mid and " .
			" ( gperm_groupid=" . XOOPS_GROUP_ANONYMOUS ." or gperm_groupid= " . XOOPS_GROUP_USERS .") " ;
			redirect_header($_SERVER['PHP_SELF'],5, $sql );
			exit() ;
		$result = $xoopsDB->queryF($sql)  or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	}
	
}	
?>  