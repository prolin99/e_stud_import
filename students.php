<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-04-20
// $Id:$
// ------------------------------------------------------------------------- //
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = 'e_stud_lists.tpl';

include_once XOOPS_ROOT_PATH."/header.php";



/*-----------function區--------------*/
 if (!$xoopsUser)
  	redirect_header(XOOPS_URL,3, "需要登入，才能使用！");

  //校內教師群組代號
  $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;

if (! in_array(   $teach_group_id , $xoopsUser->groups() )  )
  	redirect_header(XOOPS_URL,3, "教職員，才能使用！");

  //班級名稱
  $data['class_name_list_c']=es_class_name_list_c('long')   ;
  $tmp_id=key($data['class_name_list_c']) ;
  /*
//取得班級列表
	$sql =  "  SELECT `class_id`  FROM " . $xoopsDB->prefix("e_student") .  "  GROUP BY `class_id`  ORDER BY  `class_id`  " ;
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
	while($list_class_id=$xoopsDB->fetchArray($result)){
		$data['class_id_list'][$list_class_id['class_id']]= $list_class_id['class_id'] ;
		$tmp_id = $list_class_id['class_id'] ;
	}
*/


/*-----------執行動作判斷區----------*/
if ( intval($_POST['class_id'])  )
	$class_id =intval($_POST['class_id'])  ;
else
	$class_id = 101 ;

if ($class_id  )  {
	//取得學生姓名
	 	$data['select_class_id'] = $class_id ;
		$sql =  "  SELECT class_id , class_sit_num ,name  FROM " . $xoopsDB->prefix("e_student") . "   where class_id='$class_id'  ORDER BY  class_id , class_sit_num  " ;
 		//echo $sql ;
		$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, $xoopsDB->error());
		while($stud=$xoopsDB->fetchArray($result)){
			$data['list'][]=$stud ;

		}
}



/*-----------秀出結果區--------------*/
/*
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', Utility::get_bootstrap());
$xoopsTpl->assign('jquery', Utility::get_jquery(true));
$xoopsTpl->assign( "data" , $data ) ;


include_once XOOPS_ROOT_PATH.'/footer.php';

?>
