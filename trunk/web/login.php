<?php 
    require_once("./include/db_info.inc.php");
	require_once("./include/my_func.inc.php");
    $vcode=trim($_POST['vcode']);
    if($OJ_VCODE&&($vcode!= $_SESSION["vcode"]||$vcode==""||$vcode==null) ){
		echo "<script language='javascript'>\n";
		echo "alert('Verify Code Wrong!');\n";
		echo "history.go(-1);\n";
		echo "</script>";
		exit(0);
    }

	$user_id=mysql_escape_string($_POST['user_id']);
	$password=$_POST['password'];
	$pass2 = 'No Saved';
	session_destroy();
	session_start();
	$sql="INSERT INTO `loginlog` VALUES('$user_id','$pass2','".$_SERVER['REMOTE_ADDR']."',NOW())";
	@mysql_query($sql) or die(mysql_error());
	$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`='".$user_id."'";
	$result=mysql_query($sql);
	$row = mysql_fetch_array($result);
	if ($row && pwCheck($password,$row['password']))
    {
		$_SESSION['user_id']=$row['user_id'];
		mysql_free_result($result);
		$sql="SELECT `rightstr` FROM `privilege` WHERE `user_id`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		echo mysql_error();
		while ($row=mysql_fetch_assoc($result))
			$_SESSION[$row['rightstr']]=true;
		echo "<script language='javascript'>\n";
		echo "history.go(-2);\n";
		echo "</script>";
	}else{
		mysql_free_result($result);
		echo "<script language='javascript'>\n";
		echo "alert('UserName or Password Wrong!');\n";
		echo "history.go(-1);\n";
		echo "</script>";
	}
?>
