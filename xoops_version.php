<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//
$modversion['name'] = _MI_ESTUDENTS_NAME;			//模組名稱
$modversion['version']	= '0.9';				//模組版次
$modversion['author'] = _MI_ESTUDENTS_AUTHOR;			//模組作者
$modversion['description'] = _MI_ESTUDENTS_DESC;		//模組說明
$modversion['credits']	= _MI_ESTUDENTS_CREDITS;		//模組授權者
$modversion['license']		= "GPL see LICENSE";		//模組版權
$modversion['official']		= 0;				//模組是否為官方發佈1，非官方0
$modversion['image']		= "images/logo.png";		//模組圖示
$modversion['dirname'] = basename(dirname(__FILE__));		//模組目錄名稱

//---模組狀態資訊---//
//$modversion['status_version'] = '0.8';
$modversion['release_date'] = '2014-04-01';
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

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 1;
//$modversion['sub'][2]['name'] =_MI_MODULE_SMNAME2;
//$modversion['sub'][2]['url'] = "aaa.php";


//---樣板設定---//
$modversion['templates'] = array();
$i=1 ;
$modversion['templates'][$i]['file'] = 'e_stud_index_tpl.html';
$modversion['templates'][$i]['description'] = "e_stud_index_tpl.html";
$i++ ;
$modversion['templates'][$i]['file'] = 'e_teacher_tpl.html';
$modversion['templates'][$i]['description'] = "e_teacher_tpl";

$i=1 ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_teacher_group';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE1';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC1';
$modversion['config'][$i]['formtype']    = 'group';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 4 ;					//配合校園網站輕鬆架，預設值

?>