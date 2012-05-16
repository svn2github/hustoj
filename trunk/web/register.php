<?php 
require_once("./include/db_info.inc.php");
require_once("./include/my_func.inc.php");
$err_str="";
$err_cnt=0;
$len;
$user_id=trim($_POST['user_id']);
$len=strlen($user_id);
$email=trim($_POST['email']);
$school=trim($_POST['school']);
$vcode=trim($_POST['vcode']);
if($OJ_VCODE&&($vcode!= $_SESSION["vcode"]||$vcode==""||$vcode==null) ){
	$_SESSION["vcode"]=null;
	$err_str=$err_str."Verification Code Wrong!\\n";
	$err_cnt++;
}
if($OJ_LOGIN_MOD!="hustoj"){
	$err_str=$err_str."System do not allow register.\\n";
	$err_cnt++;
}

if($len>20){
	$err_str=$err_str."User ID Too Long!\\n";
	$err_cnt++;
}else if ($len<3){
	$err_str=$err_str."User ID Too Short!\\n";
	$err_cnt++;
}
if (!is_valid_user_name($user_id)){
	$err_str=$err_str."User ID can only contain NUMBERs & LETTERs!\\n";
	$err_cnt++;
}
$nick=trim($_POST['nick']);
$len=strlen($nick);
if ($len>100){
	$err_str=$err_str."Nick Name Too Long!\\n";
	$err_cnt++;
}else if ($len==0) $nick=$user_id;
if (strcmp($_POST['password'],$_POST['rptpassword'])!=0){
	$err_str=$err_str."Password Not Same!\\n";
	$err_cnt++;
}
if (strlen($_POST['password'])<6){
	$err_cnt++;
	$err_str=$err_str."Password should be Longer than 6!\\n";
}
$len=strlen($_POST['school']);
if ($len>100){
	$err_str=$err_str."School Name Too Long!\\n";
	$err_cnt++;
}
$len=strlen($_POST['email']);
if ($len>100){
	$err_str=$err_str."Email Too Long!\\n";
	$err_cnt++;
}
if ($err_cnt>0){
	print "<script language='javascript'>\n";
	print "alert('";
	print $err_str;
	print "');\n history.go(-1);\n</script>";
	exit(0);
	
}
$password=pwGen($_POST['password']);
$sql="SELECT `user_id` FROM `users` WHERE `users`.`user_id` = '".$user_id."'";
$result=mysql_query($sql);
$rows_cnt=mysql_num_rows($result);
mysql_free_result($result);
if ($rows_cnt == 1){
	print "<script language='javascript'>\n";
	print "alert('User Existed!\\n');\n";
	print "history.go(-1);\n</script>";
	exit(0);
}
$nick=mysql_real_escape_string(htmlspecialchars ($nick));
$school=mysql_real_escape_string(htmlspecialchars ($school));
$email=mysql_real_escape_string(htmlspecialchars ($email));
$ip=$_SERVER['REMOTE_ADDR'];
$sql="INSERT INTO `users`("
."`user_id`,`email`,`ip`,`accesstime`,`password`,`reg_time`,`nick`,`school`)"
."VALUES('".$user_id."','".$email."','".$_SERVER['REMOTE_ADDR']."',NOW(),'".$password."',NOW(),'".$nick."','".$school."')";
mysql_query($sql);// or die("Insert Error!\n");
$sql="INSERT INTO `loginlog` VALUES('$user_id','$password','$ip',NOW())";
mysql_query($sql);
$_SESSION['user_id']=$user_id;

		$sql="SELECT `rightstr` FROM `privilege` WHERE `user_id`='".$_SESSION['user_id']."'";
		//echo $sql."<br />";
		$result=mysql_query($sql);
		echo mysql_error();
		while ($row=mysql_fetch_assoc($result)){
			$_SESSION[$row['rightstr']]=true;
			//echo $_SESSION[$row['rightstr']]."<br />";
		}
		$_SESSION['ac']=Array();
		$_SESSION['sub']=Array();
?>
<script>history.go(-2);</script>
