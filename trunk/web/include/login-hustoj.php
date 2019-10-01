<?php 
	require_once("./include/my_func.inc.php");
    
	function check_login($user_id,$password){
		global $view_errors,$OJ_EXAM_CONTEST_ID,$MSG_WARNING_DURING_EXAM_NOT_ALLOWED,$MSG_WARNING_LOGIN_FROM_DIFF_IP;	
		$pass2 = 'No Saved';
		session_destroy();
		session_start();
		$sql="SELECT `user_id`,`password` FROM `users` WHERE `user_id`=? and defunct='N' ";
		$result=pdo_query($sql,$user_id);
		if(count($result)==1){
			$row = $result[0];
			if( pwCheck($password,$row['password'])){
				$user_id=$row['user_id'];
				$ip = ($_SERVER['REMOTE_ADDR']);
				if( isset($_SERVER['HTTP_X_FORWARDED_FOR'] )&&!empty( trim( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ){
                                    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                    $tmp_ip=explode(',',$REMOTE_ADDR);
                                    $ip =(htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));
                                } else if(isset($_SERVER['HTTP_X_REAL_IP'])&& !empty( trim( $_SERVER['HTTP_X_REAL_IP'] ) ) ){
                                    $REMOTE_ADDR = $_SERVER['HTTP_X_REAL_IP'];
                                    $tmp_ip=explode(',',$REMOTE_ADDR);
                                    $ip =(htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));
                                }
				
				if(isset($OJ_EXAM_CONTEST_ID)&&intval($OJ_EXAM_CONTEST_ID)>0){
					$ccid=$OJ_EXAM_CONTEST_ID;
					$sql="select min(start_time) from contest where start_time<=now() and end_time>=now() and contest_id>=?";
					$rows=pdo_query($sql,$ccid);
					$start_time=$rows[0][0];
					$sql="select ip from loginlog where user_id=? and time>? order by time desc";
					$rows=pdo_query($sql,$user_id,$start_time);
					$lastip=$rows[0][0];
					if((!empty($lastip))&&$lastip!=$ip) {
						$view_errors="$MSG_WARNING_LOGIN_FROM_DIFF_IP($lastip/$ip) $MSG_WARNING_DURING_EXAM_NOT_ALLOWED!";
						return false;
					}
				}
				$sql="INSERT INTO `loginlog` VALUES(?,'login ok',?,NOW())";
				pdo_query($sql,$user_id,$ip);
				$sql="UPDATE users set accesstime=now() where user_id=?";
				pdo_query($sql,$user_id);
				return $user_id;
			}
		}
		return false; 
	}
?>
