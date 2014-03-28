<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
$i=0 ;
$adminmenu[$i]['title'] ='學生名冊';
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]['desc'] = '匯入學生名冊' ;
$adminmenu[$i]['icon'] = 'images/admin/home.png' ;

$i++ ;
$adminmenu[$i]['title'] = "級任設定";
$adminmenu[$i]['link'] = "admin/teacher_set.php";
$adminmenu[$i]['desc'] ='設定級任' ;
$adminmenu[$i]['icon'] = 'images/admin/main.png' ;

$i++ ;
$adminmenu[$i]['title'] = "關於";
$adminmenu[$i]['link'] = "admin/about.php";
$adminmenu[$i]['desc'] = '說明';
$adminmenu[$i]['icon'] = 'images/admin/about.png';
?>