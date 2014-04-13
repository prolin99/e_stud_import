<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-04-20
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
include_once "header_admin.php";
include_once "header.php";

$_GET['id'] ;
{
	$id_array = preg_split('/[_:]/',$_GET['id'] ) ;
    $uid = $id_array[3] ;
    $staff_id=$id_array[1] ;
    $staff =$staff_id . '-' . addSlashes($_GET['job']) ;   	
       	//echo $uid  .'--'. 	$class_id  ;
	if ( ( $uid >0 ) and 	$staff_id ) {
 		if ($_GET['do']=='del' ) 
 			$sql = " update  "  . $xoopsDB->prefix("users") ." set user_occ='' where uid='$uid'  "  ;
 		else 	
			//更新各人資料 
     		$sql = " update  "  . $xoopsDB->prefix("users") ." set user_occ='$staff' where uid='$uid'  "  ;
    	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
     	
    	
    	
    	//加入群組設定第三字為群組  ---------------------------------------
    	$group_set = substr($staff_id,2,1) ;
 
    	if ($group_set<>0) {
			if ($_GET['do']=='del' ){
				$sql = " DELETE FROM  " . $xoopsDB->prefix("groups_users_link") .
						" WHERE groupid ='$group_set' and uid ='$uid' " ;
				$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());			
			}else {
				//是否已在群組中
				$sql = "SELECT * FROM " . $xoopsDB->prefix("groups_users_link") .
						" WHERE groupid ='$group_set' and uid ='$uid' " ;
				$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
				$row=$xoopsDB->fetchArray($result) ;

				if (!$row['uid']) {
					//加入群組
					$sql = " INSERT INTO   "  . $xoopsDB->prefix("groups_users_link") .  
				" (`uid`, `groupid`)  " .
				"  VALUES  ( '$uid' , '$group_set' )   " ; 
					$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 
				}	
			}

			
    	}	
 
     }else {
     	echo "insert error  " .   $_GET['id']  . $sql  ;
     }
}     	