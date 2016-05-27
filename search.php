<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-04-20
// $Id:$
// ------------------------------------------------------------------------- //
/*-----------引入檔案區--------------*/
include_once 'header.php';
$xoopsOption['template_main'] = set_bootstrap('e_stud_search_tpl.html');

include_once XOOPS_ROOT_PATH.'/header.php';

/*-----------function區--------------*/
if (!$xoopsUser) {
     redirect_header(XOOPS_URL, 3, '需要登入，才能使用！');
}

//校內教師群組代號
$teach_group_id = $xoopsModuleConfig['es_studs_teacher_group'];

if (!in_array($teach_group_id, $xoopsUser->groups())) {
    redirect_header(XOOPS_URL, 3, '教職員，才能使用！');
}

  //班級名稱
  $data['class_name_list_c'] = es_class_name_list_c('long');

/*-----------執行動作判斷區----------*/
//$op=empty($_REQUEST['op'])?"":$_REQUEST['op'];
$myts = &MyTextSanitizer::getInstance();
$act_search = $myts->htmlSpecialChars($myts->addSlashes($_POST['act_search']));
$stud_name = $myts->htmlSpecialChars($myts->addSlashes($_POST['stud_name']));

if ($act_search == 'search' and $stud_name) {
    //多人列表
    $stud_list = preg_split('/[,\r\n\s]/', $stud_name);
    //var_dump($stud_list) ;
    foreach ($stud_list as $k => $stud_name2) {
        //取得學生姓名
        if (trim($stud_name2) != '') {
            $sql = '  SELECT class_id , class_sit_num ,name  FROM '.$xoopsDB->prefix('e_student')."   where name like '%$stud_name2%'   ORDER BY  class_id , class_sit_num  ";
            //echo $sql ;
            $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, $xoopsDB->error());
            while ($stud = $xoopsDB->fetchArray($result)) {
                $data['student'][] = $stud;
            }
        }
    }
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('bootstrap', get_bootstrap());
$xoopsTpl->assign('jquery', get_jquery(true));
$xoopsTpl->assign('data', $data);

include_once XOOPS_ROOT_PATH.'/footer.php';
