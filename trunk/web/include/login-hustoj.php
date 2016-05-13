<?php 
	require_once("./include/my_func.inc.php");
    
	function check_login($user_id,$password){
		$mysqli=$GLOBALS['mysqli'];
		$user_id=mysqli_escape_string($mysqli,$user_id);
		$pass2 = 'No Saved';
		session_destroy();
		session_start();
		$sql="INSERT INTO `loginlog` VALUES('$user_id','$pass2','".$_SERVER['REMOTE_ADDR']."',NOW())";
		@mysqli_query($mysqli,$sql) or die(mysql_error());
		$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`='".$user_id."'";
		$result=mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_array($result);
		if($row && pwCheck($password,$row['password'])){
			$user_id=$row['user_id'];
			mysqli_free_result($result);
			return $user_id;
		}
		mysqli_free_result($result);
		return false; 
	}
?>
