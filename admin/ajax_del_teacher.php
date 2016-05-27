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
       //	echo $uid  .'--'. 	$class_id  ;
	if ( ( $uid >0 ) and 	$class_id ) {
		 $sql = " update   "  . $xoopsDB->prefix("e_classteacher") .   " set  class_id=''   " . 
	     	   "  where uid= '$uid'  and class_id= '$class_id'    " ; 
 
 
     		$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error()); 
     		
     		// 為級任教師則去除
     		$staff =addSlashes($_GET['job']) ;
     		$sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='' where uid='$uid' and staff ='$staff'  "  ;
    		$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());
     		
     	}else {
     		echo "delete  error  " .   $_GET['id']  . $sql  ;
     	}
}    

 