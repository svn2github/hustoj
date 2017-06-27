<?php 
	require_once("./include/my_func.inc.php");
    
	function check_login($user_id,$password){
		
		$pass2 = 'No Saved';
		session_destroy();
		session_start();
		$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`=? and defunct='N' ";
		$result=pdo_query($sql,$user_id);
		if(count($result)==1){
			$row = $result[0];
			if( pwCheck($password,$row['password'])){
				$user_id=$row['user_id'];
				$sql="INSERT INTO `loginlog` VALUES(?,'login ok',?,NOW())";
				pdo_query($sql,$user_id,$_SERVER['REMOTE_ADDR']);
				return $user_id;
			}
		}
		return false; 
	}
?>
