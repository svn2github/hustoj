<?php 
$cache_time=30; 
$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$now=strftime("%Y-%m-%d %H:%M",time());
if (isset($_GET['cid'])) $ucid="&cid=".intval($_GET['cid']);
else $ucid="";
require_once("./include/db_info.inc.php");

	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}

$pr_flag=false;
$co_flag=false;
if (isset($_GET['id'])){
	// practice
	$id=intval($_GET['id']);
  //require("oj-header.php");
	if (!isset($_SESSION['administrator']) && $id!=1000)
		$sql="SELECT * FROM `problem` WHERE `problem_id`=$id AND `defunct`='N' AND `problem_id` NOT IN (
				SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
						SELECT `contest_id` FROM `contest` WHERE `end_time`>'$now' or `private`='1'))
                                ";
	else
		$sql="SELECT * FROM `problem` WHERE `problem_id`=$id";

	$pr_flag=true;
}else if (isset($_GET['cid']) && isset($_GET['pid'])){
	// contest
	$cid=intval($_GET['cid']);
	$pid=intval($_GET['pid']);

	if (!isset($_SESSION['administrator']))
		$sql="SELECT langmask,private,defunct FROM `contest` WHERE `defunct`='N' AND `contest_id`=$cid AND `start_time`<'$now'";
	else
		$sql="SELECT langmask,private,defunct FROM `contest` WHERE `defunct`='N' AND `contest_id`=$cid";
	$result=mysql_query($sql);
	$rows_cnt=mysql_num_rows($result);
	$row=mysql_fetch_row($result);
	$contest_ok=true;
	if ($row[1] && !isset($_SESSION['c'.$cid])) $contest_ok=false;
	if ($row[2]=='Y') $contest_ok=false;
	if (isset($_SESSION['administrator'])) $contest_ok=true;
				
	
    $ok_cnt=$rows_cnt==1;		
	$langmask=$row[0];
	mysql_free_result($result);
	if ($ok_cnt!=1){
		// not started
		$view_errors=  "No such Contest!";
	
		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}else{
		// started
		$sql="SELECT * FROM `problem` WHERE `defunct`='N' AND `problem_id`=(
			SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=$cid AND `num`=$pid
			)";
	}
	// public
	if (!$contest_ok){
	
		$view_errors= "Not Invited!";
		require("template/".$OJ_TEMPLATE."/error.php");
		exit(0);
	}
	$co_flag=true;
}else{
	$view_errors=  "<title>$MSG_NO_SUCH_PROBLEM</title><h2>$MSG_NO_SUCH_PROBLEM</h2>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}
$result=mysql_query($sql) or die(mysql_error());

	
if (mysql_num_rows($result)!=1){
   $view_errors="";
   if(isset($_GET['id'])){
      $id=intval($_GET['id']);
	   mysql_free_result($result);
	   $sql="SELECT  contest.`contest_id` , contest.`title`,contest_problem.num FROM `contest_problem`,`contest` WHERE contest.contest_id=contest_problem.contest_id and `problem_id`=$id and defunct='N'  ORDER BY `num`";
	   //echo $sql;
           $result=mysql_query($sql);
	   if($i=mysql_num_rows($result)){
	      echo "This problem is in Contest(s) below:<br>";
		   for (;$i>0;$i--){
				$row=mysql_fetch_row($result);
				$view_errors.= "<a href=problem.php?cid=$row[0]&pid=$row[2]>Contest $row[0]:$row[1]</a><br>";
				
			}
				 
				
		}else{
			$view_title= "<title>$MSG_NO_SUCH_PROBLEM!</title>";
			$view_errors.= "<h2>$MSG_NO_SUCH_PROBLEM!</h2>";
		}
   }else{
		$view_title= "<title>$MSG_NO_SUCH_PROBLEM!</title>";
		$view_errors.= "<h2>$MSG_NO_SUCH_PROBLEM!</h2>";
	}
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}else{
	$row=mysql_fetch_object($result);
	
	$view_title= $row->title;
	
}
mysql_free_result($result);


/////////////////////////Template
require("template/".$OJ_TEMPLATE."/problem.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
