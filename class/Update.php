<?php

namespace XoopsModules\E_stud_import;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{





 public static  function chk_add_log(){
   global $xoopsDB;
   $sql="select count(*) from ".$xoopsDB->prefix("es_log");
   $result=$xoopsDB->query($sql);
   if(empty($result)) return false;
   return true;
 }

 public static function  go_update_add_log(){
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
 public static function  chk_add_staff(){
   global $xoopsDB;
   $sql="select count(`staff`)  from ".$xoopsDB->prefix("e_classteacher");
   $result=$xoopsDB->query($sql);
   if(empty($result)) return false;
   return true;
 }

 public static function  go_update_add_staff(){
    global $xoopsDB;

 	$sql="ALTER TABLE  ".$xoopsDB->prefix("e_classteacher") .  "  ADD `staff` varchar(80) NOT NULL default ''  ,
 	 	ADD `teacher_kind` varchar(60) NOT NULL DEFAULT '' ,
 	 	ADD `teach_memo` varchar(60) DEFAULT NULL  ,
 	 	ADD `teach_condition` tinyint(3) unsigned NOT NULL DEFAULT '0' ,
 	 	ADD `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ;  " ;

    $xoopsDB->queryF($sql)  ;

 }

}
