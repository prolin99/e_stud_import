<?php
//  ------------------------------------------------------------------------ //
// 本模組由 無名氏 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

include_once "common/tool.php";
include_once "function.php";

//判斷是否對該模組有管理權限
$isAdmin=isAdmin();



$interface_menu[_MD_MODULE_SMNAME1]="index.php";


if($isAdmin){
  $interface_menu[_TO_ADMIN_PAGE]="admin/index.php";
}


//給獨立模組用的登出按鈕
$interface_menu=logout_button($interface_menu);

//模組前台選單
$module_menu=toolbar($interface_menu);

//引入CSS樣式表檔案
$module_css="<link rel='stylesheet' type='text/css' media='screen' href='module.css' />";

?>