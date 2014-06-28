<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-04-20
// $Id:$
//使用 e_classteacher 資料表 staff  欄位 來記錄職稱 例：360002-級任教師
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";
include_once "header.php";

$_GET['id'] ;
{
	$id_array = preg_split('/[_]/',$_GET['id'] ) ;
    $uid = $id_array[1] ;
    $group_id=$id_array[4] ;
 


    if ( ( $uid >0 ) and 	($group_id> XOOPS_GROUP_ANONYMOUS ) ) {
 	    if  ($_GET['do']=='del' ) 
			user_in_group($uid, $group_id ,'del') ;
 		if  ($_GET['do']=='add' ) 
			user_in_group($uid, $group_id  ) ;
   	
		echo "$uid, $group_id  ok " ;
     }else {
     	echo "insert error  " .   $_GET['id']     ;
     }
}     	