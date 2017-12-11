<?php
////////////////////////////Common head
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
        require_once('./include/db_info.inc.php');
        require_once('./include/memcache.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
 $result=false;	
///////////////////////////MAIN	
	
	$view_category="";
	$sql=	"select distinct source "
			."FROM `problem` "
			."LIMIT 500";
	$result=mysql_query_cache($sql);//mysql_escape_string($sql));
	$category=array();
        foreach ($result as $row){
		$cate=explode(" ",$row['source']);
		foreach($cate as $cat){
			array_push($category,trim($cat));	
		}
	}
	$category=array_unique($category);
	if (!$result){
		$view_category= "<h3>No Category Now!</h3>";
	}else{
		$view_category.= "<div><p>";
		
		foreach ($category as $cat){
			if(trim($cat)=="") continue;
			$view_category.= "<a class='btn btn-primary' href='problemset.php?search=".htmlentities($cat,ENT_QUOTES,'UTF-8')."'>".$cat."</a>&nbsp;";
		}
		
		$view_category.= "</p></div>";
	}

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/category.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
