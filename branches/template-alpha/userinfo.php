<?php
 $cache_time=10; 
 $OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	require_once("./include/const.inc.php");
	require_once("./include/my_func.inc.php");
 // check user
$user=$_GET['user'];
if (!is_valid_user_name($user)){
	echo "No such User!";
	exit(0);
}
$view_title=$user ."@".$OJ_NAME;
$user_mysql=mysql_real_escape_string($user);
$sql="SELECT `school`,`email`,`nick` FROM `users` WHERE `user_id`='$user_mysql'";
$result=mysql_query($sql);
$row_cnt=mysql_num_rows($result);
if ($row_cnt==0){ 
	$view_errors= "No such User!";
	require("template/".$OJ_TEMPLATE."/error.html");
	exit(0);
}

$row=mysql_fetch_object($result);
$school=$row->school;
$email=$row->email;
$nick=$row->nick;
mysql_free_result($result);
// count solved
$sql="SELECT count(DISTINCT problem_id) as `ac` FROM `solution` WHERE `user_id`='".$user_mysql."' AND `result`=4";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_object($result);
$AC=$row->ac;
mysql_free_result($result);
// count submission
$sql="SELECT count(solution_id) as `Submit` FROM `solution` WHERE `user_id`='".$user_mysql."'";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_object($result);
$Submit=$row->Submit;
mysql_free_result($result);
// update solved 
$sql="UPDATE `users` SET `solved`='".strval($AC)."',`submit`='".strval($Submit)."' WHERE `user_id`='".$user_mysql."'";
$result=mysql_query($sql);
$sql="SELECT count(*) as `Rank` FROM `users` WHERE `solved`>$AC";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Rank=intval($row[0])+1;

 if (isset($_SESSION['administrator'])){
$sql="SELECT * FROM `loginlog` WHERE `user_id`='$user_mysql' order by `time` desc LIMIT 0,10";
$result=mysql_query($sql) or die(mysql_error());
$view_userinfo=array();
$i=0;
for (;$row=mysql_fetch_row($result);){
	$view_userinfo[$i]=$row;
	$i++;
}
echo "</table>";
mysql_free_result($result);
}
$sql="SELECT result,count(1) FROM solution WHERE `user_id`='$user_mysql'  AND result>=4 group by result order by result";
	$result=mysql_query($sql);
	$view_userstat=array();
	while($row=mysql_fetch_array($result)){
		$view_userstat[$i++]=$row;
	}
	mysql_free_result($result);

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/userinfo.html");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

