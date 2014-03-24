<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-03-01
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";
include_once "header.php";

$_GET['id'] ;
{
	$id_array = preg_split('/[_:]/',$_GET['id'] ) ;
       	$uid = $id_array[1] ;
       	$class_id=$id_array[3] ;
       	//echo $uid  .'--'. 	$class_id  ;
	if ( ( $uid >0 ) and 	$class_id ) {
		 $sql = " INSERT INTO   "  . $xoopsDB->prefix("e_classteacher") .  
	     	   " (`uid`, `class_id`)  " .
	     	   "  VALUES  ( '$uid' , '$class_id' )   " ; 
 
 
     		$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 
     		
     		//echo "insert ok    " ;
     		
     		
     	}else {
     		echo "insert error  " .   $_GET['id']  . $sql  ;
     	}
}     	