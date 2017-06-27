<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-04-20
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once "header.php";
$xoopsOption['template_main'] = "e_teacherweb.tpl";

include_once XOOPS_ROOT_PATH."/header.php";


/*-----------function區--------------*/
  //校內教師群組代號
  $teach_group_id = $xoopsModuleConfig['es_studs_teacher_group']  ;

  $eamil_show = $xoopsModuleConfig['es_email_show'];
  //校內教師群組代號，學校成員時，全部顯示 EMAIL
  if ($xoopsUser) {
      if (in_array($teach_group_id, $xoopsUser->groups())) {
          $in_school = true ;
      }
  }
  $data['teacher'] = get_teacher_list($teach_group_id ,1 , $eamil_show , $in_school  ) ;

  //班級名稱
  $data['class_name_list_c']=es_class_name_list_c('long')   ;
/*-----------執行動作判斷區----------*/
//$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];



/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
//$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
//$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign( "data" , $data ) ;


include_once XOOPS_ROOT_PATH.'/footer.php';

?>
