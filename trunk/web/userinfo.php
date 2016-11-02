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
$user_mysql=mysqli_real_escape_string($mysqli,$user);
$sql="SELECT `school`,`email`,`nick` FROM `users` WHERE `user_id`='$user_mysql'";
$result=mysqli_query($mysqli,$sql);
$row_cnt=mysqli_num_rows($result);
if ($row_cnt==0){ 
	$view_errors= "No such User!";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}

$row=mysqli_fetch_object($result);
$school=$row->school;
$email=$row->email;
$nick=$row->nick;
mysqli_free_result($result);
// count solved
$sql="SELECT count(DISTINCT problem_id) as `ac` FROM `solution` WHERE `user_id`='".$user_mysql."' AND `result`=4";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$row=mysqli_fetch_object($result);
$AC=$row->ac;
mysqli_free_result($result);
// count submission
$sql="SELECT count(solution_id) as `Submit` FROM `solution` WHERE `user_id`='".$user_mysql."' and  problem_id>0";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$row=mysqli_fetch_object($result);
$Submit=$row->Submit;
mysqli_free_result($result);
// update solved 
$sql="UPDATE `users` SET `solved`='".strval($AC)."',`submit`='".strval($Submit)."' WHERE `user_id`='".$user_mysql."'";
$result=mysqli_query($mysqli,$sql);
$sql="SELECT count(*) as `Rank` FROM `users` WHERE `solved`>$AC";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_array($result);
$Rank=intval($row[0])+1;

 if (isset($_SESSION['administrator'])){
$sql="SELECT * FROM `loginlog` WHERE `user_id`='$user_mysql' order by `time` desc LIMIT 0,10";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error());
$view_userinfo=array();
$i=0;
for (;$row=mysqli_fetch_row($result);){
	$view_userinfo[$i]=$row;
	$i++;
}
echo "</table>";
mysqli_free_result($result);
}
$sql="SELECT result,count(1) FROM solution WHERE `user_id`='$user_mysql'  AND result>=4 group by result order by result";
	$result=mysqli_query($mysqli,$sql);
	$view_userstat=array();
	$i=0;
	while($row=mysqli_fetch_array($result)){
		$view_userstat[$i++]=$row;
	}
	mysqli_free_result($result);

$sql=	"SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM `solution` where  `user_id`='$user_mysql'   group by md order by md desc ";
	$result=mysqli_query($mysqli,$sql);//mysql_escape_string($sql));
	$chart_data_all= array();
//echo $sql;
    
	while ($row=mysqli_fetch_array($result)){
		$chart_data_all[$row['md']]=$row['c'];
    }
    
$sql=	"SELECT UNIX_TIMESTAMP(date(in_date))*1000 md,count(1) c FROM `solution` where  `user_id`='$user_mysql' and result=4 group by md order by md desc ";
	$result=mysqli_query($mysqli,$sql);//mysql_escape_string($sql));
	$chart_data_ac= array();
//echo $sql;
    
	while ($row=mysqli_fetch_array($result)){
		$chart_data_ac[$row['md']]=$row['c'];
    }
  
  mysqli_free_result($result);
    
/////////////////////////Template
require("template/".$OJ_TEMPLATE."/userinfo.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

