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
		//加入班級
		$sql = " INSERT INTO   "  . $xoopsDB->prefix("e_classteacher") .  
	     	   " (`uid`, `class_id`)  " .
	     	   "  VALUES  ( '$uid' , '$class_id' )   " ; 
   		$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 
     		

     	//更新各人資料 為級任教師  (已有職稱不修改)
     	$staff =addSlashes($_GET['job']) ;
     	$sql = " update  "  . $xoopsDB->prefix("users") ." set user_occ='$staff' where uid='$uid'  and user_occ=''  "  ;
    	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
     	
     		
     }else {
     	echo "insert error  " .   $_GET['id']  . $sql  ;
     }
}     	