<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

////////////////////////////Common head
$cache_time = 2;
$OJ_CACHE_SHARE = false;

require_once('./include/cache_start.php');
require_once('./include/db_info.inc.php');
require_once('./include/memcache.php');
require_once("./include/const.inc.php");
require_once('./include/setlang.php');

if (isset($OJ_LANG)) {
	require_once("./lang/$OJ_LANG.php");
}

function formatTimeLength($length) {
  $hour = 0;
  $minute = 0;
  $second = 0;
  $result = '';

  global $MSG_SECONDS, $MSG_MINUTES, $MSG_HOURS, $MSG_DAYS;

  if ($length>=60) {
    $second = $length%60;
    
    if ($second>0 && $second<10) {
    	$result = '0'.$second.' '.$MSG_SECONDS;}
    else if ($second>0) {
    	$result = $second.' '.$MSG_SECONDS;
    }

    $length = floor($length/60);
    if ($length >= 60) {
      $minute = $length%60;
      
      if ($minute==0) {
      	if ($result != '') {
      		$result = '00'.' '.$MSG_MINUTES.' '.$result;
      	}
      }
      else if ($minute>0 && $minute<10) {
      	if ($result != '') {
      		$result = '0'.$minute.' '.$MSG_MINUTES.' '.$result;}
				}
				else {
					$result = $minute.' '.$MSG_MINUTES.' '.$result;
				}
				
				$length = floor($length/60);

				if ($length >= 24) {
					$hour = $length%24;

				if ($hour==0) {
					if ($result != '') {
						$result = '00'.' '.$MSG_HOURS.' '.$result;
					}
				}
				else if ($hour>0 && $hour<10) {
					if($result != '') {
						$result = '0'.$hour.' '.$MSG_HOURS.' '.$result;
					}
				}
				else {
					$result = $hour.' '.$MSG_HOURS.' '.$result;
				}

				$length = floor($length / 24);
				$result = $length .$MSG_DAYS.' '.$result;
			}
			else {
				$result = $length.' '.$MSG_HOURS.' '.$result;
			}
		}
		else {
			$result = $length.' '.$MSG_MINUTES.' '.$result;
		}
	}
	else {
		$result = $length.' '.$MSG_SECONDS;
	}
	return $result;
}

if (isset($_GET['cid'])) {
	$cid = intval($_GET['cid']);
	$view_cid = $cid;
	//print $cid;

	//check contest valid
	$sql = "SELECT * FROM `contest` WHERE `contest_id`=?";
	$result = pdo_query($sql,$cid);

	$rows_cnt = count($result);
	$contest_ok = true;
	$password = "";

	if (isset($_POST['password']))
		$password = $_POST['password'];

	if (get_magic_quotes_gpc()) {
		$password = stripslashes($password);
	}

	if ($rows_cnt==0) {
		$view_title = "比赛已经关闭!";
	}
	else{
		$row = $result[0];
		$view_private = $row['private'];

		if ($password!="" && $password==$row['password'])
			$_SESSION[$OJ_NAME.'_'.'c'.$cid] = true;

		if ($row['private'] && !isset($_SESSION[$OJ_NAME.'_'.'c'.$cid]))
			$contest_ok = false;

		if($row['defunct']=='Y')
			$contest_ok = false;

		if (isset($_SESSION[$OJ_NAME.'_'.'administrator']))
			$contest_ok = true;

		$now = time();
		$start_time = strtotime($row['start_time']);
		$end_time = strtotime($row['end_time']);
		$view_description = $row['description'];
		$view_title = $row['title'];
		$view_start_time = $row['start_time'];
		$view_end_time = $row['end_time'];

		if (!isset($_SESSION[$OJ_NAME.'_'.'administrator']) && $now<$start_time) {
			$view_errors = "<center>";
			$view_errors .= "<h3>$MSG_CONTEST_ID : $view_cid - $view_title</h3>";
			$view_errors .= "<p>$view_description</p>";
			$view_errors .= "<br>";
			$view_errors .= "<span class=text-success>$MSG_TIME_WARNING</span>";
			$view_errors .= "</center>";
			$view_errors .= "<br><br>";

			require("template/".$OJ_TEMPLATE."/error.php");
			exit(0);
		}
	}

	if (!$contest_ok) {
		$view_errors = "<center>";
		$view_errors .= "<h3>$MSG_CONTEST_ID : $view_cid - $view_title</h3>";
		$view_errors .= "<p>$view_description</p>";
		$view_errors .= "<span class=text-danger>$MSG_PRIVATE_WARNING</span>";

		$view_errors .= "<br><br>";

		$view_errors .= "<div class='btn-group'>";
		$view_errors .= "<a href=contestrank.php?cid=$view_cid class='btn btn-primary'>$MSG_STANDING</a>";
		$view_errors .= "<a href=contestrank-oi.php?cid=$view_cid class='btn btn-primary'>OI$MSG_STANDING</a>";
		$view_errors .= "<a href=conteststatistics.php?cid=$view_cid class='btn btn-primary'>$MSG_STATISTICS</a>";
		$view_errors .= "</div>";

		$view_errors .= "<br><br>";
		$view_errors .= "<table align=center width=80%>";
		$view_errors .= "<tr align='center'>";
		$view_errors .= "<td>";
		$view_errors .= "<form class=form-inline method=post action=contest.php?cid=$cid>";
		$view_errors .= "<input class=input-mini type=password name=password value='' placeholder=$MSG_CONTEST-$MSG_PASSWORD>";
		$view_errors .= "<button class='form-control'>$MSG_SUBMIT</button>";
		$view_errors .= "</form>";
		$view_errors .= "</td>";
		$view_errors .= "</tr>";
		$view_errors .= "</table>";
		$view_errors .= "<br>";

		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}
}

$result2="";
if ((isset($_SESSION[$OJ_NAME.'_'.'administrator']) || isset($_SESSION[$OJ_NAME.'_'.'contest_creator']))&& isset($_POST['do'])) {

	$user_id = $_POST['user_id'];
  $ip = $_POST['ip'];

  if(get_magic_quotes_gpc()){
		$user_id = stripslashes($user_id);
		$ip = stripslashes($ip);
	}

	$sql = "insert into loginlog (user_id,password,ip,time) value(?,?,?,now())";
	$result = pdo_query($sql,$user_id,"set ip by ".$_SESSION[$OJ_NAME."_user_id"],$ip);
	$result2 = "changed";
}

/////////////////////////Template
if (isset($_GET['cid']))
  require("template/".$OJ_TEMPLATE."/user_set_ip.php");

/////////////////////////Common foot
if (file_exists('./include/cache_end.php') )
  require_once('./include/cache_end.php');
?>
