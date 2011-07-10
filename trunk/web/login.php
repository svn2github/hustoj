<?php require_once("./include/db_info.inc.php");
	$user_id=mysql_escape_string($_POST['user_id']);
	$password=MD5($_POST['password']);
	session_destroy();
	session_start();
	$sql="INSERT INTO `loginlog` VALUES('$user_id','$password','".$_SERVER['REMOTE_ADDR']."',NOW())";
	@mysql_query($sql) or die(mysql_error());
	$sql="SELECT `user_id` FROM `users` WHERE `user_id`='".$user_id."' AND `password`='".$password."'";
	$result=mysql_query($sql);
	$cnt_row=mysql_num_rows($result);
	if ($cnt_row==1){
		$row=mysql_fetch_object($result);
		$_SESSION['user_id']=$row->user_id;
		mysql_free_result($result);
		$sql="SELECT `rightstr` FROM `privilege` WHERE `user_id`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		echo mysql_error();
		while ($row=mysql_fetch_assoc($result))
			$_SESSION[$row['rightstr']]=true;
//		$_SESSION['ac']=Array();
//		$_SESSION['sub']=Array();
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
