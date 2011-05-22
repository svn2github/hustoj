<?
	@session_start();
static 	$DB_HOST="127.1";
static 	$DB_NAME="jol";
static 	$DB_USER="root";
static 	$DB_PASS="root";
	// connect db 
static 	$OJ_NAME="HUSTOJ";
static 	$OJ_HOME="./";
static 	$OJ_ADMIN="root@localhost";
static 	$OJ_DATA="/home/judge/data";
static 	$OJ_BBS="discuss";//"bbs" for phpBB3 bridge or "discuss" for mini-forum
static  $OJ_ONLINE=false;
static  $OJ_LANG="en";
static  $OJ_SIM=true; 
static  $OJ_DICT=true;
static  $OJ_LANGMASK=0; //1mC 2mCPP 4mPascal 8mJava 16mRuby 32mBash 
static  $OJ_EDITE_AREA=true;//true: syntax highlighting is active
static  $OJ_AUTO_SHARE=false;//true: One can view all AC submit if he/she has ACed it onece.
static  $OJ_CSS="hoj.css";
if (isset($_SESSION['OJ_LANG'])) $OJ_LANG=$_SESSION['OJ_LANG'];
//for normal install
	if(mysql_pconnect($DB_HOST,$DB_USER,$DB_PASS));
	else die('Could not connect: ' . mysql_error());
	
// for sae.sina.com.cn
// mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
// $DB_NAME=SAE_MYSQL_DB;

	// use db
	mysql_query("set names utf8");
	mysql_set_charset("utf8");
	
	if(mysql_select_db($DB_NAME));
	else die('Can\'t use foo : ' . mysql_error());
	date_default_timezone_set("PRC");
?>
