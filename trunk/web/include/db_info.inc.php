<?
	$DB_HOST="localhost";
	$DB_NAME="180_testjol";
	$DB_USER="180_root";
	$DB_PASS="root";
	// connect db 
	$OJ_NAME="FPS-OJ";
	$OJ_HOME="http://code.google.com/p/freeproblemset/";
	$OJ_ADMIN="root@localhost";
	$OJ_DATA="/home/zhblue/testoj/";
	if(mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS));
	else die('Could not connect: ' . mysql_error());
	// use db
	mysql_query("set names utf8");
	mysql_set_charset("utf8");
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());
	@session_start();
?>
