<?php
/*-----------引入檔案區--------------*/
include_once "header_admin.php";
if ($_GET['id']){
 	$sql=  "  DELETE FROM   " . $xoopsDB->prefix("es_log")  ."  where id='{$_GET['id']}'  ";	   	
 	$result = $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());	
}