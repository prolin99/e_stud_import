<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-02-16
// $Id:$
// ------------------------------------------------------------------------- //

//---基本設定---//
$modversion['name'] = _MI_ESTUDENTS_NAME;			//模組名稱
$modversion['version']	= '1.3';				//模組版次
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
$modversion['tables'][3] = "e_staff";

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//---使用者主選單設定---//
$modversion['hasMain'] = 0;



//---樣板設定---//
$modversion['templates'] = array();
$i=1 ;
$modversion['templates'][$i]['file'] = 'e_teacherweb_tpl.html';
$modversion['templates'][$i]['description'] = "e_teacherweb_tpl.html";
$i++ ;
$modversion['templates'][$i]['file'] = 'e_teacher_tpl.html';
$modversion['templates'][$i]['description'] = "e_teacher_tpl";
$i++ ;
$modversion['templates'][$i]['file'] = 'staff_tpl.html';
$modversion['templates'][$i]['description'] = "staff_tpl";
$i++ ;
$modversion['templates'][$i]['file'] = 'e_students_tpl.html';
$modversion['templates'][$i]['description'] = "e_students_tpl";
$i++ ;
$modversion['templates'][$i]['file'] = 'e_stud_web_tpl.html';
$modversion['templates'][$i]['description'] = "e_stud_web_tpl";

$i=1 ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_teacher_group';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE1';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC1';
$modversion['config'][$i]['formtype']    = 'group';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default'] = 4 ;					//配合校園網站輕鬆架，預設值


 
$i++ ;
//偏好設定
$modversion['config'][$i]['name'] = 'es_studs_teacher_job';
$modversion['config'][$i]['title']   = '_MI_ESTUDENTS_CONFIG_TITLE2';
$modversion['config'][$i]['description'] = '_MI_ESTUDENTS_CONFIG_DESC2';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default'] = "000101-校長 \n115101-教務主任 \n126101-學務主任 \n137101-總務主任\n148101-輔導主任 \n150101-人事主任 \n150102-會計主任 \n170101-幼稚園主任 \n215102-教學組長 \n215103-註冊組長 \n215104-課發組長 \n215105-資訊組長 \n226102-訓育組長 \n226103-體育組長 \n226104-衛生組長 \n226011-護理師 \n237102-出納組長 \n237103-事務組長 \n237104-文書組長 \n237011-幹事 \n237012-營養師  \n248101-輔導組長 \n248102-特教組長 \n248103-資料組長 \n270102-教保組長 \n360001-學年主任 \n360002-級任教師 \n360003-科任教師 \n360004-特教教師 \n360011-實習教師 \n360012-代理教師 \n370003-幼稚園教師 \n370004-教保員 \n430021-工友 \n430022-警衛 \n430023-替代役 \n430024-雇員\n990000-離職人員" ;  	
 
?>