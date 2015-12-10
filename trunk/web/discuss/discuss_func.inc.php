<?php
function problem_exist($pid,$cid){
	require("../include/db_info.inc.php");
	if ($pid=='') $pid=0;
	if ($cid!='')
		$cid=intval($cid);
	else
		$cid='NULL';
	if($pid!=0)
		if($cid!='NULL')
			$sql="SELECT 1 FROM `contest_problem` WHERE `contest_id` = $cid AND `problem_id` = '".intval($pid)."'";
		else
			$sql="SELECT 1 FROM `problem` WHERE `problem_id` = ".intval($pid)."";
	else if($cid!='NULL')
		$sql="SELECT 1 FROM `contest` WHERE `contest_id` = $cid";
	else
		return true;
	$sql.=" LIMIT 1";
	//echo $sql;
	$result=mysqli_query($mysqli,$sql) or print "db error";
	return mysqli_num_rows($result)>0;
}
function err_msg($msg){
	require_once("oj-header.php");
	echo $msg;
	require_once("oj-footer.php");
	exit(0);
}
?>
