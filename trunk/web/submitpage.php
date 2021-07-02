<?php
require_once('./include/db_info.inc.php');
require_once('./include/const.inc.php');
require_once('./include/memcache.php');
require_once('./include/setlang.php');

$view_title = $MSG_SUBMIT;

if (!isset($_SESSION[$OJ_NAME.'_'.'user_id'])){
	if (isset($OJ_GUEST) && $OJ_GUEST) {
		$_SESSION[$OJ_NAME.'_'.'user_id'] = "Guest";
	}
	else {
		$view_errors = "<a href=loginpage.php>$MSG_Login</a>";
		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}
}

$problem_id = 1000;
if (isset($_GET['id'])) {
	$id = intval($_GET['id']);
	$sample_sql = "SELECT sample_input,sample_output,problem_id FROM problem WHERE problem_id = ?";
}
else if (isset($_GET['cid']) && isset($_GET['pid'])) {
	$cid = intval($_GET['cid']);
	$pid = intval($_GET['pid']);

	$psql = "SELECT problem_id FROM contest_problem WHERE contest_id=? AND num=?";
	$data = pdo_query($psql,$cid,$pid);

	$row = $data[0];
	$problem_id = $row[0];
	$sample_sql = "SELECT p.sample_input, p.sample_output, p.problem_id FROM problem p WHERE problem_id = ? ";
}
else {
	$view_errors = "<h2>No Such Problem!</h2>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}

$view_src = "";

if (isset($_GET['sid'])) {
  $sid = intval($_GET['sid']);
	$sql = "SELECT * FROM `solution` WHERE `solution_id`=?";
	$result = pdo_query($sql,$sid);

	$row = $result[0];
	$cid = intval($row['contest_id']);
	$sproblem_id= intval($row['problem_id']);
	$contest_id=$cid;
	if ($row && $row['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id'])
		$ok = true;

		$need_check_using=true;
		if ( $contest_id > 0 ){
			$sql="select start_time,end_time from contest where contest_id=?";
			$result=pdo_query($sql,$contest_id);
			if($result){
				$row=$result[0];
				$start_time = strtotime($row['start_time']);
				$end_time = strtotime($row['end_time']);
				$now=time();
				if( $end_time < $now ){ // 当前提交，属于已经结束的比赛，考察是否有进行中的比赛在使用。
					$need_check_using=true;
					
				}else{			// 属于进行中的比赛，可以看
							
		//			echo $now.'-'.$end_time;
					$need_check_using=false;
				
				}
			}

		}else{ //非比赛提交.考察是否有进行中的比赛在使用
		//			echo $now.'+'.$end_time;

					$need_check_using=true;
		}
		// 检查是否使用中
		//echo $now.'*'.$end_time;
		$now = strftime("%Y-%m-%d %H:%M", time());
		$sql="select contest_id from contest where contest_id in (select contest_id from contest_problem where problem_id=?) 
									and start_time < '$now' and end_time > '$now' ";
		if($need_check_using){
			//echo $sql;
			$result=pdo_query($sql,$sproblem_id);
			if(count($result)>0){
					$view_errors = "<center>";
					$view_errors .= "<h3>$MSG_CONTEST_ID : ".$result[0][0]."</h3>";
					$view_errors .= "<p> $MSG_SOURCE_NOT_ALLOWED_FOR_EXAM </p>";
					$view_errors .= "<br>";
					$view_errors .= "</center>";
					$view_errors .= "<br><br>";
					require("template/".$OJ_TEMPLATE."/error.php");
					exit(0);
			}

		}
	if (isset($_SESSION[$OJ_NAME.'_'.'source_browser'])) {
		$ok = true;
	}
	else {




		if (isset($OJ_EXAM_CONTEST_ID)) {
			if ($cid < $OJ_EXAM_CONTEST_ID && !isset($_SESSION[$OJ_NAME.'_'.'source_browser'])) {

					$view_errors = "<center>";
					$view_errors .= "<h3>$MSG_CONTEST_ID : ".$OJ_EXAM_CONTEST_ID."+ </h3>";
					$view_errors .= "<p> $MSG_SOURCE_NOT_ALLOWED_FOR_EXAM </p>";
					$view_errors .= "<br>";
					$view_errors .= "</center>";
					$view_errors .= "<br><br>";
					require("template/".$OJ_TEMPLATE."/error.php");
					exit(0);
			}
		}
	}

	if ($ok == true) {
		$sql = "SELECT `source` FROM `source_code_user` WHERE `solution_id`=?";
		$result = pdo_query($sql,$sid);

		$row = $result[0];

		if ($row)
			$view_src = $row['source'];

		$sql = "SELECT langmask FROM contest WHERE contest_id=?";

		$result = pdo_query($sql,$cid);
		$row = $result[0];

		if ($row)
			$_GET['langmask'] = $row['langmask'];
	}
}

if (isset($id))
	$problem_id = $id;

$view_sample_input = "1 2";
$view_sample_output = "3";

if (isset($sample_sql)) {
	//echo $sample_sql;
	if (isset($_GET['id'])) {
		$result = pdo_query($sample_sql,$id);
	}
	else {
	  $result = pdo_query($sample_sql,$problem_id);
	}

	if($result == false)
	{
		$view_errors = "<h2>No Such Problem!</h2>";
		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}

	$row = $result[0];
	$view_sample_input = $row[0];
	$view_sample_output = $row[1];
	$problem_id = $row[2];
}

$lastlang = 0;
if (!$view_src) {
	if (isset($_COOKIE['lastlang']) && $_COOKIE['lastlang']!="undefined") {
		$lastlang = intval($_COOKIE['lastlang']);
	}
	else {
		$sql = "SELECT language FROM solution WHERE user_id=? ORDER BY solution_id DESC LIMIT 1";
		$result = pdo_query($sql,$_SESSION[$OJ_NAME.'_'.'user_id']);

		if (count($result)>0) {
			$lastlang = $result[0][0];
		}
		else {
			$lastlang = 0;
		}
		//echo "last=$lastlang";
	}
	$template_file = "$OJ_DATA/$problem_id/template.".$language_ext[$lastlang];

	if (file_exists($template_file)) {
		$view_src = file_get_contents($template_file);
	}
}

$sql = "SELECT count(1) FROM `solution` WHERE result<4";
$result = mysql_query_cache($sql);

$row = $result[0];

if ($row[0]>10) {
	$OJ_VCODE = true;
	//$OJ_TEST_RUN=false;
	//echo "$row[0]";
}

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/submitpage.php");
/////////////////////////Common foot
?>
