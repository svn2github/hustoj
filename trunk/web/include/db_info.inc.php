<?
	$DB_HOST="localhost";
	$DB_NAME="jol";
	$DB_USER="root";
	$DB_PASS="";
	// connect db
	$OJ_NAME="HUST-OJ";
	$OJ_HOME="http://code.google.com/p/hustoj/";
	$OJ_ADMIN="root@localhost";
	if(mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS));
	else die('Could not connect: ' . mysql_error());
	// use db
	mysql_query("set names utf8");
	mysql_set_charset("utf8");
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());
	@session_start();
?>
