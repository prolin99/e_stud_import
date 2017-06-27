<?php
//載入XOOPS主設定檔（必要）
include_once "../../mainfile.php";
//載入自訂的共同函數檔
include_once "function.php";



//回模組首頁
$interface_menu[_TAD_TO_MOD]="index.php";
$interface_icon[_TAD_TO_MOD]="fa-chevron-right";


if ($xoopsUser) {

  $interface_menu['學生搜尋']="search.php";
  $interface_menu['學生名冊']="students.php";
  $interface_menu['學生統計']="statistics.php";
}


//判斷是否對該模組有管理權限
$isAdmin=false;

if ($xoopsUser) {
  $module_id = $xoopsModule->getVar('mid');
  $isAdmin=$xoopsUser->isAdmin($module_id);
}
//模組後台
if($isAdmin){
  $interface_menu[_TAD_TO_ADMIN]="admin/main.php";
  $interface_icon[_TAD_TO_ADMIN]="fa-chevron-right";
}
