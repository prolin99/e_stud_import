<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header.php";
include_once "../function.php";

	//取得記錄檔十筆
	$sql=  " select  message   from  " . $xoopsDB->prefix("es_log")  ."  where id='{$_GET['id']}'  ";
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	$row=$xoopsDB->fetchArray($result) ;
	echo $row['message'] ;


//include_once 'footer.php';
