<?php	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
	if (!isset($_SESSION['user_id'])){
		$view_errors= "<a href=./loginpage.php>$MSG_Login</a>";
		
		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}

$sql="SELECT `school`,`nick`,`email` FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);

mysqli_free_result($result);
/////////////////////////Template
require("template/".$OJ_TEMPLATE."/modifypage.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

