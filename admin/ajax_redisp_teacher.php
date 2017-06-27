<?php
/*-----------引入檔案區--------------*/
include_once "header.php";
include_once "../function.php";

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
        $output.=" <span  class='tea' data_ref='teacher_{$uid}_{$teacher['name']}'   id='tea_{$uid}' >
        	<label id='teacher_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-success' style='display: none;'>{$teacher['name']}</label></span> " ;
	}else {
        $output.=" <span  class='tea' id='tea_{$uid}'  data_ref='teacher_{$uid}_{$teacher['name']}'   >
        <label id='teacher_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-success'>{$teacher['name']}</label></span> " ;
    }

}

echo "<h4>教師列表</h4>\n $output $button" ;
