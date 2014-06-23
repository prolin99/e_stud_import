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
	$id_array = preg_split('/[_:]/',$_GET['id'] ) ;
    $uid = $id_array[3] ;
    $staff_id=$id_array[1] ;
    $staff =$staff_id . '-' . addSlashes($_GET['job']) ;   	

    //校內教師群組代號
    $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;

    if ( ( $uid >0 ) and 	$staff_id ) {

 	    if  ($_GET['do']=='del' ){
		
            //移除職稱
            $sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='' where uid='$uid'  "  ;
            $result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());

            if ($staff_id== '990000') //把離職條件去除，再加回校內群組中
                user_in_group($uid, $teach_group_id  ) ;
        }else {
		    //指定職稱
            if ($staff_id== '990000') { //離職人員，無職稱，去群組
                $sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='' where uid='$uid'  "  ;
                $result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
                //把校內群組移除
                user_in_group($uid, $teach_group_id ,'del' ) ;
            }else{
                //加入職稱加群組
 
              //檢查是否已在表中
		$sql = " select uid , staff  from "  . $xoopsDB->prefix("e_classteacher") .  " where uid='$uid'  " ;
	 	$result = $xoopsDB->queryF($sql) ; 
		$row=$xoopsDB->fetchArray($result) ;
		$guid = $row['uid'] ;
 		if ($guid) {
     	        	$sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set staff='$staff' where uid='$uid'  "  ;
		}else {
     	        	$sql = " INSERT INTO "  . $xoopsDB->prefix("e_classteacher") .  
	     	   			" (`uid`, `class_id` ,staff )  " .
	     	   			"  VALUES  ( '$uid' , '$class_id' , '$staff'  )   " ; 
		}	
	   	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
              	user_in_group($uid, $teach_group_id  ) ;
            }

        }
     	
    	
    	
    	//加入群組設定第三字為群組  ---------------------------------------
    	$group_set = substr($staff_id,2,1) ;
 
    	if ($group_set<>0) {
			if ($_GET['do']=='del' ) 
				user_in_group($uid, $group_set ,'del') ;
 			 else  
				user_in_group($uid, $group_set) ;
    	}	


     }else {
     	echo "insert error  " .   $_GET['id']  . $sql  ;
     }
}     	