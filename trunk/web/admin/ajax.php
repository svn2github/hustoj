<?php
require_once("admin-header.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if($_SERVER['REQUEST_METHOD']=="POST"){
	$m=$_POST["m"];	
	if($m=="problem_add_source"){
		$pid=intval($_POST['pid']);
		$new_source=($_POST['ns']);	
		$sql= "update problem set source=concat(source,' ',?) where problem_id=?";		
		echo pdo_query($sql,$new_source,$pid);
	}
	if($m=="problem_update_time"){
		$pid=intval($_POST['pid']);
		$time=intval($_POST['t']);	
		$sql= "update problem set time_limit=? where problem_id=?";		
		echo pdo_query($sql,$time,$pid);
	}
}
