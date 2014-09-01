<?php
/**

 * User: user
 * Date: 2014/4/16
 * Time: 下午 9:25
 */
/*-----------引入檔案區--------------*/
include_once "header_admin.php";
include_once "header.php";

$_GET['mode'] = !$_GET['mode'] ;

if ($_GET['mode']){
    $gid=XOOPS_GROUP_USERS ;    //註冊者
    $output_b ="<div> <button  id='show_register' class='btn btn-warning' smode='1' >全部註冊人員(切換)</button></div>" ;
}else{
    $gid=$xoopsModuleConfig['es_studs_teacher_group']  ; //校內人員
    $output_b ="<div> <button  id='show_register' class='btn btn-primary' smode='0' >校內人員(切換)</button></div>" ;
}


$teacher_list = get_teacher_list($gid) ;

foreach($teacher_list as $uid =>$teacher){
    if ($teacher['staff']) {
        //<!-- 已設職稱  -->
        list($sid,$job) = preg_split('/[-]/',$teacher['staff']) ;
        $output.=" <span class='span3'><label  id='tea_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-inverse'>" ;
        $output.="{$teacher['name']}_$job <span class='del' id='sta_$sid:tea_$uid'> ";
      	$output.=" <i class='icon-trash icon-white'></i></span></label> " ;
        $output.=" </span>" ;
    }else {
        $output.=" <span class='span3'><label  id='tea_{$uid}' title='{$teacher['name']}({$teacher['uname']})' name_title='{$teacher['name']}' class='label label-success'>" ;
        $output.="{$teacher['name']}" ;
        $output.=" </span>" ;

    }

}

echo " <div class='row-fluid'>
              <div class='span3'><h4>教師列表</h4></div>$output_b</div>\n $output" ;
