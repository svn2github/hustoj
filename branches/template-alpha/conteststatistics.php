<?php
	$OJ_CACHE_SHARE=true;
	$cache_time=30;
	require_once("./include/db_info.inc.php");
	require_once("./include/const.inc.php");
	require_once("./include/my_func.inc.php");

// contest start time
if (!isset($_GET['cid'])) die("No Such Contest!");
$cid=intval($_GET['cid']);

$sql="SELECT * FROM `contest` WHERE `contest_id`='$cid' AND `start_time`<NOW()";
$result=mysql_query($sql);
$num=mysql_num_rows($result);
if ($num==0){
	$view_errors= "Not Started!";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}
mysql_free_result($result);

$view_title= "Contest Statistics";

$sql="SELECT count(`num`) FROM `contest_problem` WHERE `contest_id`='$cid'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$pid_cnt=intval($row[0]);
mysql_free_result($result);

$sql="SELECT `result`,`num`,`language` FROM `solution` WHERE `contest_id`='$cid' and num>=0"; 
$result=mysql_query($sql);
$R=array();
while ($row=mysql_fetch_object($result)){
	$res=intval($row->result)-4;
	if ($res<0) $res=8;
	$num=intval($row->num);
	$lag=intval($row->language);
	if(!isset($R[$num][$res]))
		$R[$num][$res]=1;
	else
		$R[$num][$res]++;
	if(!isset($R[$num][$lag+10]))
		$R[$num][$lag+10]=1;
	else
		$R[$num][$lag+10]++;
	if(!isset($R[$pid_cnt][$res]))
		$R[$pid_cnt][$res]=1;
	else
		$R[$pid_cnt][$res]++;
	if(!isset($R[$pid_cnt][$lag+10]))
		$R[$pid_cnt][$lag+10]=1;
	else
		$R[$pid_cnt][$lag+10]++;
	if(!isset($R[$num][8]))
		$R[$num][8]=1;
	else
		$R[$num][8]++;
	if(!isset($R[$pid_cnt][8]))
		$R[$pid_cnt][8]=1;
	else
		$R[$pid_cnt][8]++;
}
mysql_free_result($result);
/////////////////////////Template
require("template/".$OJ_TEMPLATE."/conteststatistics.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
