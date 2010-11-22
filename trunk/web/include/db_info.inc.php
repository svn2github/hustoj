<?
	@session_start();
static 	$DB_HOST="127.1";
static 	$DB_NAME="jol";
static 	$DB_USER="root";
static 	$DB_PASS="root";
	// connect db 
static 	$OJ_NAME="FPS-OJ";
static 	$OJ_HOME="http://code.google.com/p/freeproblemset/";
static 	$OJ_ADMIN="root@localhost";
static 	$OJ_DATA="/home/judge/data";
static 	$OJ_BBS="discuss";//"bbs" for phpBB3 bridge or "discuss" for mini-forum
static  $OJ_ONLINE=false;
static  $OJ_LANG="en";
static  $OJ_SIM=false;
if (isset($_SESSION['OJ_LANG'])) $OJ_LANG=$_SESSION['OJ_LANG'];
	if(mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS));
	else die('Could not connect: ' . mysql_error());
	// use db
	mysql_query("set names utf8");
	mysql_set_charset("utf8");
	
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());

?>
