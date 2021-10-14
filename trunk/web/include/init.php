<?php
require_once(dirname(__FILE__)."/pdo.php");

//if(date('H')<5||date('H')>21||isset($_GET['dark'])) $OJ_CSS="dark.css";
if (isset($_SESSION[$OJ_NAME . '_' . 'OJ_LANG'])) {
	$OJ_LANG=$_SESSION[$OJ_NAME . '_' . 'OJ_LANG'];
} else if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], array("cn", "ug", "en", 'fa', 'ko', 'th'))) {
	$OJ_LANG=$_COOKIE['lang'];
} else if (isset($_GET['lang']) && in_array($_GET['lang'], array("cn", "ug", "en", 'fa', 'ko', 'th'))) {
	$OJ_LANG=$_GET['lang'];
} else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && strstr($_SERVER['HTTP_ACCEPT_LANGUAGE'], "zh-CN")) {
	$OJ_LANG="cn";
}

$domain=basename($_SERVER["HTTP_HOST"]);

if($OJ_SaaS_ENABLE){
	$DOMAIN="my.hustoj.com";
	$OJ_SaaS_CONF=realpath(dirname(__FILE__)."/..")."/SaaS/".basename($_SERVER["HTTP_HOST"]).".php";
	if(file_exists($OJ_SaaS_CONF)){
		require_once($OJ_SaaS_CONF);
	}else{
	//	echo $OJ_SaaS_CONF;
	}
}else{
	$DOMAIN=$domain;
}

$OJ_LOG_FILE="/var/log/hustoj/{$OJ_NAME}.log";
require_once(dirname(__FILE__) . "/logger.php");

$logger=new Logger(isset($_SESSION[$OJ_NAME . '_' . 'user_id'])?$_SESSION[$OJ_NAME . '_' . 'user_id']:"guest", 
					$OJ_LOG_FILE, 
					$OJ_LOG_DATETIME_FORMAT, 
					$OJ_LOG_ENABLED, 
					$OJ_LOG_PID_ENABLED,
					$OJ_LOG_USER_ENABLED,
					$OJ_LOG_URL_ENABLED,
					$OJ_LOG_URL_HOST_ENABLED,
					$OJ_LOG_URL_PARAM_ENABLED,
					$OJ_LOG_TRACE_ENABLED);
$logger->info();
// these lines can help you make a SaaS platform of HUSTOJ with the help of JudgeHub
// 傻瓜级保姆配置系统
switch($OJ_FRIENDLY_LEVEL) {
	case 9:
	   $OJ_GUEST=true;
	case 8:
	   $OJ_DOWNLOAD=true;
	case 7:
	   $OJ_BBS="discuss3";
	case 6:
	   $OJ_LONG_LOGIN=true; 
	case 5:
	   $OJ_TEST_RUN=true; 
	case 4:
	   $OJ_MAIL=true;
	   $OJ_AUTO_SHARE=true;
	case 3:
	   $OJ_SHOW_DIFF=true; 
	   $OJ_VCODE=false;
	case 2:
	   $OJ_LANG="cn";
	case 1:
	   date_default_timezone_set("PRC");
	   pdo_query("SET time_zone ='+8:00'");
}
