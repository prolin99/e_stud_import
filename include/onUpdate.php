<?php

function xoops_module_update_e_stud_import(&$module, $old_version) {
    GLOBAL $xoopsDB;

    if(!chk_add_log()) go_update_add_log();


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
	) ;  " ;
  $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL,3,  mysql_error());
}
?>
