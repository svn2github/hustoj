<?php 
	require_once("./include/my_func.inc.php");
    
	function check_login($user_id,$password){
		session_destroy();
		session_start();
		$discuz_host="127.0.0.1";
		$discuz_port="3306";
		$discuz_user="root";
		$discuz_db="discuz";
		$discuz_pass="root";
		$discuz_conn=mysql_connect($discuz_host.":".$discuz_port,$discuz_user,$discuz_pass);

		$ret=false;
		pdo_query("set names utf8");
		$sql="select password,salt,username from ".$discuz_db.".uc_members where username='$user_id'";
		$result=pdo_query($sql);
		$row = $result[0];
		if($discuz_conn){
			mysql_select_db($discuz_db,$discuz_conn);
			$result=pdo_query($sql,$discuz_conn);
		
			if($row['password']==md5(md5($password).$row['salt'])){

					$_SESSION[$OJ_NAME.'_'.'user_id']=$row['username'];
					$ret=$_SESSION[$OJ_NAME.'_'.'user_id'];
				//	$sql="insert into jol.users(user_id,ip,nick,school) values('".$_SESSION[$OJ_NAME.'_'.'user_id']."','','','') on DUPLICATE KEY UPDATE nick='".$row['username']."'";
				//	pdo_query($sql);
					
			}

		}
		
				
		return $ret; 
	}
?>
