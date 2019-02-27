<?php
////////////////////////////Common head
	$cache_time=1200;
	$OJ_CACHE_SHARE=true;
	require_once('./include/cache_start.php');
	require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Recent Contests from Naikai-contest-spider";
	
	// bs ie sweet 除外的模板依旧使用老方法
	if($OJ_TEMPLATE!="bs3"&&$OJ_TEMPLATE!="sweet"&&$OJ_TEMPLATE!="ie"){
		$json = @file_get_contents('http://contests.acmicpc.info/contests.json');
		$rows = json_decode($json, true);
	}
	



/////////////////////////Template
require("template/".$OJ_TEMPLATE."/recent-contest.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>



