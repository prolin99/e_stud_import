<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//
$modversion['name'] = _MI_ESTUDENTS_NAME;			//模組名稱
$modversion['version']	= '2.6';				//模組版次
$modversion['author'] = _MI_ESTUDENTS_AUTHOR;			//模組作者
$modversion['description'] = _MI_ESTUDENTS_DESC;		//模組說明
$modversion['credits']	= _MI_ESTUDENTS_CREDITS;		//模組授權者
$modversion['license']		= "GPL see LICENSE";		//模組版權
$modversion['official']		= 0;				//模組是否為官方發佈1，非官方0
$modversion['image']		= "images/logo.png";		//模組圖示
$modversion['dirname'] = basename(dirname(__FILE__));		//模組目錄名稱

//---模組狀態資訊---//
//$modversion['status_version'] = '0.8';
$modversion['release_date'] = '2016-06-04';
$modversion['module_website_url'] = 'https://github.com/prolin99/e_stud_import';
$modversion['module_website_name'] = 'prolin';
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'http://www.syps.tn.edu.tw';
$modversion['author_website_name'] = 'prolin';
$modversion['min_php']= 5.2;
$modversion['min_xoops']='2.5';


//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;//---資料表架構---//
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][1] = "e_student";
$modversion['tables'][2] = "e_classteacher";
$modversion['tables'][3] = "es_log";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---安裝設定---//
$modversion['onUpdate'] = "include/onUpdate.php";



//---樣板設定---//
$modversion['templates'] = array();
$i=0 ;
$i++ ;
$modversion['templates'][$i]['file'] = 'e_teacherweb.tpl';
$modversion['templates'][$i]['description'] = "e_teacherweb.tpl";

$i++ ;
$modversion['templates'][$i]['file'] = 'e_s_adm_teacher.tpl';
$modversion['templates'][$i]['description'] = "e_s_adm_teacher.tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_s_adm_staff.tpl';
$modversion['templates'][$i]['description'] = "e_s_adm_staff.tpl";



$i++ ;
$modversion['templates'][$i]['file'] = 'e_s_adm_studweb.tpl';
$modversion['templates'][$i]['description'] = "e_s_adm_studweb.tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_stud_adm_main.tpl';
$modversion['templates'][$i]['description'] = "e_stud_adm_main.tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_s_adm_group.tpl';
$modversion['templates'][$i]['description'] = "e_s_adm_group.tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_stud_search.tpl';
$modversion['templates'][$i]['description'] = "e_stud_search_tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_stud_lists.tpl';
$modversion['templates'][$i]['description'] = "e_stud_lists_tpl";

$i++ ;
$modversion['templates'][$i]['file'] = 'e_stat.tpl';
$modversion['templates'][$i]['description'] = "e_stat_tpl";


$i++ ;
$modversion['templates'][$i]['file'] = 'e_s_adm_new.tpl';
$modversion['templates'][$i]['description'] = "e_s_adm_new_tpl";





$i=1 ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_teacher_group';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE1';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC1';
$modversion['config'][$i]['formtype']    = 'group';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 4 ;					//配合校園網站輕鬆架，預設值

$i++ ;
//偏好設定，在群組設定中要出現的群組
$modversion['config'][$i]['name'] = 'es_studs_group_list';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_G_LIST';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DG_LIST';
$modversion['config'][$i]['formtype']    = 'group_multi';
$modversion['config'][$i]['valuetype']   = 'array';
$modversion['config'][$i]['default'] = array(4,5,6,7,8,9)  ;					//配合校園網站輕鬆架，預設值

$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_email_show';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE6';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC6';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 1 ;					//匯入未指定座號0，預填為

$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_stud_sit_id';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE4';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC4';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 35 ;					//匯入未指定座號0，預填為


$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_teacher_job';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE2';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC2';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default'] = "000101-校長 \n115101-教務主任 \n126101-學務主任 \n137101-總務主任\n148101-輔導主任 \n150101-人事主任 \n150102-會計主任 \n170101-幼稚園主任 \n215102-教學組長 \n215103-註冊組長 \n215104-課發組長 \n215105-資訊組長 \n226102-訓育組長 \n226103-體育組長 \n226104-衛生組長 \n237102-出納組長 \n237103-事務組長 \n237104-文書組長   \n248101-輔導組長 \n248102-特教組長 \n248103-資料組長 \n270102-教保組長 \n360001-學年主任 \n360002-級任教師 \n360003-科任教師 \n360004-特教教師 \n360011-實習教師 \n360012-代理教師 \n370003-幼稚園教師 \n370004-教保員 \n450010-護理師 \n450011-幹事 \n450012-營養師 \n450013-心理師 \n450021-工友 \n450022-警衛 \n450023-替代役 \n450024-雇員\n990000-離職人員" ;


$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_exweb';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE3';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC3';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default'] = "<a href='play.php?flv=__class_id/__sitid.flv&name=__name&class=__class_id' target='web' >__sitid.__name</a>\n<a href='/lifetype/index.php?blogId=__class_id__sitid' target='web' >__sitid.__name </a> " ;

$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_stud_parent_doc';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE5';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC5';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default'] = '可以圈選兩名！' ;

$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_stud_stud_dn';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_stud_down';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC_stud_down';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default'] = '' ;


$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_stud_deny_personid';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_T_PERSON';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_D_PERSON';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 1 ;
?>
