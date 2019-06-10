<?php
require_once("admin-header.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if($_SERVER['REQUEST_METHOD']=="GET"){
	$m=$_GET["m"];	
	if($m=="problem_add_source"){
		$pid=intval($_GET['pid']);
		$new_source=($_GET['ns']);	
		$sql= "update problem set source=concat(source,' ',?) where problem_id=?";		
		echo pdo_query($sql,$new_source,$pid);
	}
}
