<?php

function xoops_module_update_e_stud_import(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_add_log()) go_update_add_log();
    if(!chk_add_staff()) go_update_add_staff();

    return true;
}


function chk_add_log(){
  global $xoopsDB;
  $sql="select count(*) from ".$xoopsDB->prefix("es_log");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_log(){
  global $xoopsDB;
 
	 $sql="CREATE TABLE ".$xoopsDB->prefix("es_log")." (
  	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`module` varchar(255) NOT NULL,
  	`message` text NOT NULL,
  	`rec_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  	PRIMARY KEY (`id`)
	) ENGINE=MyISAM ;  " ;
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  $xoopsDB->error());
}

//----------------------------------------------------------------------------------------
function chk_add_staff(){
  global $xoopsDB;
  $sql="select count(`staff`)  from ".$xoopsDB->prefix("e_classteacher");
  $result=$xoopsDB->query($sql);
  if(empty($result)) return false;
  return true;
}

function go_update_add_staff(){
  global $xoopsDB;
 
	 $sql="ALTER TABLE  ".$xoopsDB->prefix("e_classteacher") .  "  ADD `staff` varchar(80) NOT NULL default ''  ,
	 	ADD `teacher_kind` varchar(60) NOT NULL DEFAULT '' ,
	 	ADD `teach_memo` varchar(60) DEFAULT NULL  ,
	 	ADD `teach_condition` tinyint(3) unsigned NOT NULL DEFAULT '0' ,
	 	ADD `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ;  " ;
 
  $xoopsDB->queryF($sql)  ;
 
}


?>