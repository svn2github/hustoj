<?
	$DB_HOST="";
	$DB_NAME="";
	$DB_USER="";
	$DB_PASS="";
	// connect db
	if(mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS));
	else die('Could not connect: ' . mysql_error());
	// use db
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());
	@session_start();
?>
