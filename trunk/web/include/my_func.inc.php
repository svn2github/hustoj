<?php function is_valid_user_name($user_name){
	$len=strlen($user_name);
	for ($i=0;$i<$len;$i++){
		if (
			($user_name[$i]>='a' && $user_name[$i]<='z') ||
			($user_name[$i]>='A' && $user_name[$i]<='Z') ||
			($user_name[$i]>='0' && $user_name[$i]<='9') ||
			$user_name[$i]=='_'
		);
		else return false;
	}
	return true;
}

function sec2str($sec){
	return sprintf("%02d:%02d:%02d",$sec/3600,$sec%3600/60,$sec%60);
}

function is_running($cid){
	require_once("./include/db_info.inc.php");
	$sql="SELECT count(*) FROM `contest` WHERE `contest_id`='$cid' AND `end_time`>NOW()";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$cnt=intval($row[0]);
	mysql_free_result($result);
	return $cnt>0;
}

function check_ac($cid,$pid){
	require_once("./include/db_info.inc.php");
	$sql="SELECT count(*) FROM `solution` WHERE `contest_id`='$cid' AND `num`='$pid' AND `result`='4' AND `user_id`='".$_SESSION['user_id']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$ac=intval($row[0]);
	mysql_free_result($result);
	if ($ac>0) return "<font color=green>Y</font>";
	$sql="SELECT count(*) FROM `solution` WHERE `contest_id`='$cid' AND `num`='$pid' AND `user_id`='".$_SESSION['user_id']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$sub=intval($row[0]);
	mysql_free_result($result);
	if ($sub>0) return "<font color=red>N</font>";
	else return "";
}
?>
