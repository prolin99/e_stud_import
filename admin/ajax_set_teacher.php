<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
//指定級任1
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

	if ( ( $uid >0 ) and $class_id ) {
		//有指定才做
		$staff =addSlashes($_GET['job']) ;


		//清除目前班級的級任設定
		$sql = " update   "  . $xoopsDB->prefix("e_classteacher") .  " set staff =''  ,  class_id =''  where (staff =  '$staff' )  and (class_id =  '$class_id'  ) " ;
   		$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());

   		$sql = " update   "  . $xoopsDB->prefix("e_classteacher") .  " set class_id=''  where class_id =  '$class_id'  " ;
   		$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());


		//檢查教師是否是否已在表中
		$sql = " select uid , staff   from    "  . $xoopsDB->prefix("e_classteacher") .  " where uid='$uid'  " ;

		$result = $xoopsDB->queryF($sql) ;
		$row=$xoopsDB->fetchArray($result) ;
		$guid = $row['uid'] ;
		$gstaff = $row['staff'] ;

		if  ( $guid ) {
			//更新
			if ( !$gstaff )
				$set_staff = "  , staff='$staff ' " ;
			$sql = " update  "  . $xoopsDB->prefix("e_classteacher") ." set class_id='$class_id'  $set_staff  where uid='$uid'   "  ;
			$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());
		}else {

			//加入班級
			$sql = " INSERT INTO   "  . $xoopsDB->prefix("e_classteacher") .
	     	   			" (`uid`, `class_id` ,staff )  " .
	     	   			"  VALUES  ( '$uid' , '$class_id' , '$staff'  )   " ;
   			$result = $xoopsDB->queryF($sql) or die($sql."<br>". $xoopsDB->error());
		}


        //指定為校內人員
        $gid=$xoopsModuleConfig['es_studs_teacher_group']  ; //校內人員
        user_in_group($uid, $gid  ) ;

     }else {
     	echo "insert error  " .   $_GET['id']  . $sql  ;
     }
}
