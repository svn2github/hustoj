<?

require_once("./include/db_info.inc.php");

if ($_SESSION['postkey']!=$_POST['postkey'])
	exit(1);

$err_str="";
$err_cnt=0;
$len;
$user_id=$_SESSION['user_id'];
$email=trim($_POST['email']);
$school=trim($_POST['school']);
$nick=trim($_POST['nick']);
$len=strlen($nick);
if ($len>100){
	$err_str=$err_str."Nick Name Too Long!\n";
	$err_cnt++;
}else if ($len==0) $nick=$user_id;
$password=MD5($_POST['opassword']);
$sql="SELECT `user_id` FROM `users` WHERE `user_id`='".$user_id."' AND `password`='".$password."'";
$result=mysql_query($sql);
$rows_cnt=mysql_num_rows($result);
mysql_free_result($result);
if ($rows_cnt==0){
	$err_str=$err_str."Old Password Wrong";
	$err_cnt++;
}
$len=strlen($_POST['npassword']);
if ($len<6 && $len>0){
	$err_cnt++;
	$err_str=$err_str."Password should be Longer than 6!\n";
}else if (strcmp($_POST['npassword'],$_POST['rptpassword'])!=0){
	$err_str=$err_str."Two Passwords Not Same!\n";
	$err_cnt++;
}
$len=strlen($_POST['school']);
if ($len>100){
	$err_str=$err_str."School Name Too Long!\n";
	$err_cnt++;
}
$len=strlen($_POST['email']);
if ($len>100){
	$err_str=$err_str."Email Too Long!\n";
	$err_cnt++;
}
if ($err_cnt>0){
	print "<script language='javascript'>\n";
	print "alert('";
	print $err_str;
	print "');\n history.go(-1);\n</script>";
	exit(0);
	
}
if (strlen($_POST['npassword'])==0) 
	$password=MD5($_POST['opassword']);
else 
	$password=MD5($_POST['npassword']);
$nick=mysql_real_escape_string(htmlspecialchars ($nick));
$school=mysql_real_escape_string(htmlspecialchars ($school));
$email=mysql_real_escape_string(htmlspecialchars ($email));
$sql="UPDATE `users` SET"
."`password`='".($password)."',"
."`nick`='".($nick)."',"
."`school`='".($school)."',"
."`email`='".($email)."' "
."WHERE `user_id`='".mysql_real_escape_string($user_id)."'"
;
//echo $sql;
//exit(0);
mysql_query($sql);// or die("Insert Error!\n");
header("Location: ./");
?>
