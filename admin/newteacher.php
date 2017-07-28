<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
//樣版
$xoopsOption['template_main'] = "e_s_adm_new.tpl";
include_once "header.php";
include_once "../function.php";

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
$data['teacher'] = get_teacher_list($teach_group_id ,1 , $eamil_show , $in_school ,'new'  ) ;

//班級名稱
$data['class_name_list_c']=es_class_name_list_c('long')   ;

/*-----------秀出結果區--------------*/
$xoopsTpl->assign( "data" , $data ) ;


include_once 'footer.php';

?>
