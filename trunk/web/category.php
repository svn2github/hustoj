<?php
////////////////////////////Common head
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
 $result=false;	
///////////////////////////MAIN	
	
	$view_category="";
	$sql=	"select distinct source "
			."FROM `problem` "
			."LIMIT 500";
	$result=pdo_query($sql);//mysql_escape_string($sql));
	if (!$result){
		$view_category= "<h3>No Category Now!</h3>";
	}else{
		$view_category.= "<div>";
		
		foreach ($result as $row){
			$view_category.= "<a href='problemset.php?search=".htmlentities($row['source'],ENT_QUOTES,'UTF-8')."'><h2>".$row['source']."</h2></a>&nbsp;";
		}
		
		$view_category.= "</div>";
	}

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/category.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
