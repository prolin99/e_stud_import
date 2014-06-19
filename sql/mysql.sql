CREATE TABLE `e_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stud_id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `person_id` varchar(10) NOT NULL,
   `sex` smallint(6) NOT NULL,
  `birthday` date DEFAULT NULL,
  `class_id` varchar(5) NOT NULL,
  `class_sit_num` tinyint(4) NOT NULL,
  `parent` varchar(20) DEFAULT NULL,
  `chk_date` date DEFAULT NULL,
  `tn_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `stud_id` (`stud_id`,`person_id`,`tn_id`)
) ENGINE=MyISAM COMMENT='學生名冊' AUTO_INCREMENT=1 ;

CREATE TABLE  `e_classteacher` (
  `uid`  int(11)  NOT NULL,
  `class_id` varchar(6) NOT NULL,
  `staff` varchar(80) NOT NULL DEFAULT '',
  `teacher_kind` varchar(60) NOT NULL DEFAULT '',
  `teach_memo` varchar(60) DEFAULT NULL,
  `teach_condition` tinyint(3) unsigned NOT NULL DEFAULT '0',
   `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`uid`)
) ENGINE=MyISAM COMMENT='級任'   ;

 

CREATE TABLE `es_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `rec_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM   COMMENT='記錄訊息';