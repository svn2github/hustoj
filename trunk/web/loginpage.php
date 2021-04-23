<?php
$cache_time=1;
require_once('./include/cache_start.php');
    require_once("./include/db_info.inc.php");
	require_once("./include/setlang.php");
	$view_title= "LOGIN";

	if (isset($_SESSION[$OJ_NAME.'_'.'user_id'])){
	echo "<a href=logout.php>Please logout First!</a>";
	exit(1);
}

/////////////////////////Template
if($OJ_LONG_LOGIN==true&&isset($_COOKIE[$OJ_NAME."_user"])&&isset($_COOKIE[$OJ_NAME."_check"])){
	echo"<script>let xhr=new XMLHttpRequest();xhr.open('GET','login.php',true);xhr.send();setTimeout('history.go(-1)',500);</script>";
}
else
        require("template/".$OJ_TEMPLATE."/loginpage.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
