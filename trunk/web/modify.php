<?php 
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
	require_once("./include/check_post_key.php");
	require_once("./include/my_func.inc.php");


$err_str="";
$err_cnt=0;
$len;
$user_id=$_SESSION['user_id'];
$email=trim($_POST['email']);
$school=trim($_POST['school']);
$nick=trim($_POST['nick']);
$len=strlen($nick);
if ($len>100){
	$err_str=$err_str."Nick Name Too Long!";
	$err_cnt++;
}else if ($len==0) $nick=$user_id;
$password=$_POST['opassword'];
$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`='".$user_id."'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_array($result);
if ($row && pwCheck($password,$row['password'])) $rows_cnt = 1;
else $rows_cnt = 0;
mysqli_free_result($result);
if ($rows_cnt==0){
	$err_str=$err_str."Old Password Wrong";
	$err_cnt++;
}
$len=strlen($_POST['npassword']);
if ($len<6 && $len>0){
	$err_cnt++;
	$err_str=$err_str."Password should be Longer than 6!\\n";
}else if (strcmp($_POST['npassword'],$_POST['rptpassword'])!=0){
	$err_str=$err_str."Two Passwords Not Same!";
	$err_cnt++;
}
$len=strlen($_POST['school']);
if ($len>100){
	$err_str=$err_str."School Name Too Long!";
	$err_cnt++;
}
$len=strlen($_POST['email']);
if ($len>100){
	$err_str=$err_str."Email Too Long!";
	$err_cnt++;
}
if ($err_cnt>0){
	print "<script language='javascript'>\n";
	echo "alert('";
	echo $err_str;
	print "');\n history.go(-1);\n</script>";
	exit(0);
	
}
if (strlen($_POST['npassword'])==0) $password=pwGen($_POST['opassword']);
else $password=pwGen($_POST['npassword']);
$nick=mysqli_real_escape_string($mysqli,htmlentities ($nick,ENT_QUOTES,"UTF-8"));
$school=mysqli_real_escape_string($mysqli,htmlentities ($school,ENT_QUOTES,"UTF-8"));
$email=mysqli_real_escape_string($mysqli,htmlentities ($email,ENT_QUOTES,"UTF-8"));
$sql="UPDATE `users` SET"
."`password`='".($password)."',"
."`nick`='".($nick)."',"
."`school`='".($school)."',"
."`email`='".($email)."' "
."WHERE `user_id`='".mysqli_real_escape_string($mysqli,$user_id)."'"
;
//echo $sql;
//exit(0);
mysqli_query($mysqli,$sql);// or die("Insert Error!\n");
header("Location: ./");
?>
