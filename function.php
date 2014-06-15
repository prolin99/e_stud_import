<?php
//  ------------------------------------------------------------------------ //
// 本模組由 無名氏 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //
//引入TadTools的函式庫
if(!file_exists(TADTOOLS_PATH."/tad_function.php")){
 redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50",3, _TAD_NEED_TADTOOLS);
}
include_once TADTOOLS_PATH."/tad_function.php";

/********************* 自訂函數 *********************/



/********************* 預設函數 *********************/
 

 
//檢查群組權限是否訪客可以查看( true 代表權限設定是 ok，否則提醒) 
function is_safe_chk() {
	global  $xoopsDB , $xoopsModule ;
	//取得目前代號
	$mod_id = $xoopsModule->getVar('mid')  ;
	$mod_name = $xoopsModule->getVar('name', 'n')  ;
 
	
	//檢查訪客、註冊者有無讀取權限，如果有出現訊息提醒
	$sql =  "  SELECT count(*) as cc  FROM " . $xoopsDB->prefix("group_permission") . 
			" where   gperm_itemid =$mod_id and   ( gperm_groupid =". XOOPS_GROUP_ANONYMOUS  ."  or   gperm_groupid =" . XOOPS_GROUP_USERS .")  " ;
 			
	$result = $xoopsDB->query($sql) or die($sql."<br>". mysql_error()); 			
	while($date_list=$xoopsDB->fetchArray($result)){
		$cc = $date_list['cc'] ;
	}
	if ($cc>0) {
		 redirect_header( XOOPS_URL ,3, $mod_name . '模組，使用權限設定不正確，請把訪客、註冊者權限移除');
		return false ;
	}else 	
		return true ;
	
}

 
//取得職稱陣列
function get_staff_list() {
	global $xoopsModuleConfig ;
	//以逗號、分行
	$staff_list  = preg_split('/[,\r\n]/' ,$xoopsModuleConfig['es_studs_teacher_job']) ;
	foreach ($staff_list as $k=>$v) {
		//代號-職稱
		$staff_job = preg_split('/[-]/' , $v) ;
		$sid= trim($staff_job[0]) ;
		$job= trim($staff_job[1]) ;
		if ($sid and $job ) {
			if ($job == '級任教師' ) 
				$staff['class_tid'] = "$sid-$job" ;			//級任代號
			if ($job == '科任教師' ) 
				$staff['sect_tid'] = "$sid-$job" ;			//級任代號	
			$staff['id'][$sid] = $job ;
			$staff['job'][$job] = $sid ;
		}	
	}	
	

	return $staff ;
}	
 
//取得教師名冊， 群組代碼， 顯示模式(0:只取資料， 1:轉換EMAIL、職稱)
function get_teacher_list($teach_group_id ,$show=0){

	global  $xoopsDB   ;
/*
SELECT u.uid, u.name, u.user_occ, g.groupid ,c.class_id
FROM `xx_groups_users_link` AS g 
LEFT JOIN `xx_users` AS u ON u.uid = g.uid
left join  xx_e_classteacher as c on u.uid = c.uid 
WHERE g.groupid =4 
group by u.uid
order by  u.user_occ ,c.class_id  	
*/
 	$sql =  "  SELECT  u.uid, u.name , u.uname ,u.email ,u.user_viewemail , u.url , u.user_occ , g.groupid ,c.class_id   FROM  " .
 			$xoopsDB->prefix("groups_users_link") .  "  AS g LEFT JOIN  " .  $xoopsDB->prefix("users") .  "  AS u ON u.uid = g.uid " .
 			" left join " . $xoopsDB->prefix("e_classteacher") ." as c on u.uid = c.uid " .
 	        "  WHERE g.groupid ='$teach_group_id'  group by u.uid   order by  u.user_occ , c.class_id , u.name " ;
  	//echo $sql ;
 	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	while($row=$xoopsDB->fetchArray($result)){
		if ($show) {
			//email
			if ($row['email'] and $row['user_viewemail']) {		//EMAIL 顯示做保護
				$row['email_show']= email_protect($row['email']) ;
			}	
			//班級
 			$job_arr = preg_split('/[-]/' ,$row['user_occ']) ;
 			$row['staff'] = $job_arr[1] ;
 			if ($row['class_id'])
 				$row['staff'] .= '-' .$row['class_id'] .'班' ;

		}
 	 	$teacher[$row['uid']]= $row ;
	}	
	return $teacher ;
}	

//EMAIL 保護
function email_protect($email) {
 
 	$email_arr = preg_split('/[@.]/' ,$email) ;
 	$e1= '&#'. ord('@') .';' ;
 	$e2='&#'. ord('.') .';' ;
 	$email_t1 = "'{$email_arr[0]}'+e1+'{$email_arr[1]}'" ;
 	for ($i=2 ; $i< count($email_arr) ;$i++) {
		$email_t1 .= "+e$i+'{$email_arr[$i]}'" ;
 	}	

	$email_output = "
	<script type='text/javascript'>
	var t1='href' ;
	var t2='mail' ;
	var t3='to:' ;
	var e1='$e1'
	var e2='.' ;
	var e3='$e2' ;
	var e4='.' ;
	var e5='$e2' ;
	var e6='.' ;
	
	document.write('<a ' +t1 +'=' +t2+t3 + $email_t1 +'>') ;
	document.write($email_t1+'</'+'a>');\n</script> \n" ;
	return $email_output  ;
}
 
//使用者加入(移除)群組
function user_in_group( $uid, $gid, $mode='add') {
	global  $xoopsDB   ;
	if  ($mode == 'add' ) {
		//是否已在群組中
		$sql = "SELECT * FROM " . $xoopsDB->prefix("groups_users_link") .
			" WHERE groupid ='$gid' and uid ='$uid' " ;
		$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());
		$row=$xoopsDB->fetchArray($result) ;

		if (!$row['uid']) {
			//加入群組
			$sql = " INSERT INTO   "  . $xoopsDB->prefix("groups_users_link") .  
				" (`uid`, `groupid`)  " .
				"  VALUES  ( '$uid' , '$gid' )   " ; 
			$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 
		}		
	}else {
		
		$sql = " DELETE FROM  " . $xoopsDB->prefix("groups_users_link") .
						" WHERE groupid ='$gid' and uid ='$uid' " ;
		$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());				
	}

			 
}	
 
//在學生資料更新前把學生人數做統計，寫入記錄檔
function do_statistics() {
	global  $xoopsDB   ;
	//年級人數統計
	$sql = "SELECT SUBSTR(class_id,1,1) as grade, count( * ) cc  FROM " . $xoopsDB->prefix("e_student") .
			"  group by  SUBSTR(class_id,1,1)  " ;
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());						
	while($row=$xoopsDB->fetchArray($result)){
		$grade .= $row['grade'] . "年級:" .  $row['cc']  .  "人<br/>" ;
		$all += $row['cc']  ;
	}	
	//班級人數統計
	$sql = " SELECT class_id, count( * ) cc FROM " . $xoopsDB->prefix("e_student") . " GROUP BY class_id  " ;
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error());						
	while($row=$xoopsDB->fetchArray($result)){
		$class .= $row['class_id'] . "班:" .  $row['cc']  .  "人<br/>" ;
	}		
	
	$main = date("Y-m-d") .  "<br/>共計 $all 人<br/> $grade $class " ;
	
	$sql = " INSERT INTO   "  . $xoopsDB->prefix("es_log") .  
				" (`module`, `message`)  " .
				"  VALUES  ( 'e_stud_import' , '$main' )   " ; 
	$result = $xoopsDB->queryF($sql) or die($sql."<br>". mysql_error()); 
	
/*	
			
			SELECT class_id, count( * ) cc
FROM `xx_e_student`
GROUP BY class_id
	SELECT SUBSTR(class_id,1,1) as grade, count( * ) cc
FROM `xx_e_student`
GROUP BY SUBSTR(class_id,1,1)

*/
}	
?>