<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版
$xoopsOption['template_main'] = "staff_tpl.html";
include_once "header_admin.php";

include_once "header.php";


/*-----------function區--------------*/
  //取得職稱陣列(由偏好中取得)
  $staff = get_staff_list() ;
  $data['staff'] =$staff['id'] ;				//代號取名稱
  $data['staff_job2id'] =$staff['job'] ;		//名稱取代號
  //	取得級任代號
  $data['staff_class_id'] = $staff['class_tid'] ;
  //  科任代號
  $data['staff_sect_id'] = $staff['sect_tid'] ;

  //校內教師群組代號
  $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;
  
  //教師名冊
  $data['teacher_list'] =get_teacher_list($teach_group_id) ;
  //	 var_dump($data['teacher_list'] ) ;
 
 
  //已指定，呈現中文名稱 
  foreach ($data['teacher_list'] as $uid => $user ) {
	//
	$job_arr = preg_split('/[-]/' , $user['staff']) ;
	$user_staff_id[$uid] = $job_arr[0] ;	//代號
	$user_staff_job[$uid] = $job_arr[1] ;	//職稱
	if (substr($job_arr[0],3,1) ==1 )  { 
		$staff_user_id[$job_arr[0]]=$uid ; 	//唯一
	}
  }	

 
 
	$data['user_staff_id'] = $user_staff_id ;
	$data['user_staff_job'] = $user_staff_job ;
	$data['staff_user_id'] = $staff_user_id ;
	
/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "data" , $data ) ; 

 
include_once 'footer.php';

?>