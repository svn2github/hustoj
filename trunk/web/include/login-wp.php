<?php 
	require_once("./include/my_func.inc.php");
    require_once("blog/wp-includes/class-phpass.php"); //point to wordpress login class
    
	function check_login($user_id,$password){
		session_destroy();
		session_start();
		$wp_host="127.0.0.1";
		$wp_port="3306";
		$wp_user="root";
		$wp_pass="root";
		$wp_db="jol";
		$wp_conn=mysql_connect($wp_host.":".$wp_port,$wp_user,$wp_pass);
		
		//$password=HashPassword($password);
		$ret=false;
		$wp_pre="wp_";
		$sql="select * from ".$wp_pre."users where user_login='".mysql_real_escape_string($user_id)."'";
		if($wp_conn){
			mysql_select_db($wp_db,$wp_conn);
			$result=mysql_query($sql,$wp_conn);
			$row=mysql_fetch_array($result);
			if($row){
                              $wp_hasher = new PasswordHash(8, TRUE);
                              if($wp_hasher->CheckPassword($password,$row['user_pass'])){
				                   $ret=$user_id;
				                   $sql="insert into users(user_id,ip,nick,school) values('".mysql_real_escape_string($user_id)."','','','') on DUPLICATE KEY UPDATE nick='".mysql_real_escape_string($user_id)."'";
					               mysql_query($sql);
				
				                   
                              }
			}
		}
		
		return $ret; 
	}
?>
