<?php
function problem_exist($pid,$cid){
	require_once("../include/db_info.inc.php");
	if ($pid=='') $pid=0;
	if ($cid!='')
		$cid="'".mysql_escape_string($cid)."'";
	else
		$cid='NULL';
	if($pid!=0)
		if($cid!='NULL')
			$sql="SELECT 1 FROM `contest_problem` WHERE `contest_id` = $cid AND `problem_id` = '".mysql_escape_string($pid)."'";
		else
			$sql="SELECT 1 FROM `problem` WHERE `problem_id` = ".intval($pid)."";
	else if($cid!='NULL')
		$sql="SELECT 1 FROM `contest` WHERE `contest_id` = $cid";
	else
		return true;
	$sql.=" LIMIT 1";
	$result=mysql_query($sql) or die(mysql_error());
	return mysql_num_rows($result)>0;
}
function err_msg($msg){
	require_once("oj-header.php");
	echo $msg;
	require_once("oj-footer.php");
	exit(0);
}
?>
