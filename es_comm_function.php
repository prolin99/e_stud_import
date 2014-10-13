<?php
//  ------------------------------------------------------------------------ //
// 本模組由 prolin 製作
// 製作日期：2014-10-16
// $Id:$
// ------------------------------------------------------------------------- //
 
 
//取得班級使用名稱
$sql=  " select id , rec_time ,message   from  " . $xoopsDB->prefix("es_log")  ."  where   module = 'es_classname' order by rec_time DESC  LIMIT 0 , 1 ";	   	
$result = $xoopsDB->query($sql) ;
while($row=$xoopsDB->fetchArray($result)){
	$ES_classname_set = $row['message'] ;
}
if ( $ES_classname_set) 
	$ES_ClassName  = preg_split('/[,\s]/' , $ES_classname_set ) ;


function es_class_name_c($class_id , $mode='short' ) {
	global $ES_ClassName ;
	$grade= array (1=>'一' ,2=>'二' , 3=>'三' , 4=>'四' , 5=>'五' , 6=>'六' , 7=>'七' , 8=>'八' , 9=>'九'   ) ;

	if ($ES_ClassName) {
		$class_order = substr($class_id ,-2)-1 ;
		$g = $grade[substr($class_id ,0,1)] ? $grade[substr($class_id ,0,1)] : substr($class_id ,0,1) ;
		$c = $ES_ClassName[$class_order ] ? $ES_ClassName[$class_order ] : substr($class_id , -2) ; 
		//$class_name = $grade[substr($class_id ,0,1)]  .  $ES_ClassName[$class_order ] ;
		if ($mode== 'short' )
			$class_name = $g . $c ;
		else 
			$class_name = $g .'年'. $c .'班' ;
	}else 
		$class_name = $class_id ;

	return  $class_name  ;
}

function es_class_name_list_c($mode='short') {
	global $xoopsDB ;
//取得班級列表
 	$sql =  "  SELECT  class_id  FROM  " . $xoopsDB->prefix("e_student") .  "    group by class_id order by class_id  " ;
 	$result = $xoopsDB->query($sql) ; 
	while($data_row=$xoopsDB->fetchArray($result)){
 	 	$class_list[$data_row['class_id']]= es_class_name_c($data_row['class_id'] , $mode);
	}	
	return $class_list ; 
}
 



?>