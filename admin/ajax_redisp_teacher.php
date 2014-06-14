<?php
/*-----------引入檔案區--------------*/
include_once "header_admin.php";
include_once "header.php";

$_GET['mode'] = !$_GET['mode'] ;

if ($_GET['mode']){
    $gid=XOOPS_GROUP_USERS ;    //註冊者
    $button ="<p> <button  id='show_register' class='btn btn-warning' smode='1' >全部註冊人員(切換)</button></p>" ;
}else{
    $gid=$xoopsModuleConfig['es_studs_teacher_group']  ; //校內人員
    $button ="<p> <button  id='show_register' class='btn btn-primary' smode='0' >校內人員(切換)</button></p>" ;
}


$teacher_list = get_teacher_list($gid) ;

foreach($teacher_list as $uid =>$teacher){
    if ($teacher['class_id']) {
        $output.=" <label id='teacher_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-success' style='display: none;'>{$teacher['name']}</label> " ;
	}else {
        $output.=" <label id='teacher_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-success'>{$teacher['name']}</label> " ;
    }

}

echo "<h4>教師列表</h4>\n $output $button" ;
