<?php
	require_once("./db_info.inc.php");
	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}else{
		require_once("./lang/en.php");
	}
    function checkmail(){
		
		$sql="SELECT count(1) FROM `mail` WHERE 
				new_mail=1 AND `to_user`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		if(!$result) return false;
		$row=mysql_fetch_row($result);
		$retmsg="<span id=red>(".$row[0].")</span>";
		mysql_free_result($result);
		return $retmsg;
	}
	
		if (isset($_SESSION['user_id'])){
				$sid=$_SESSION['user_id'];
				$profile.= "&nbsp;<a href=./modifypage.php>$MSG_USERINFO</a>&nbsp;<a href='./userinfo.php?user=$sid'><span id=red>$sid</span></a>&nbsp;";
				$mail=checkmail();
				if ($mail)
					$profile.= "<a href=./mail.php>$mail</a>&nbsp;";
				$profile.= "<a href=./logout.php>$MSG_LOGOUT</a>&nbsp;";
			}else{
				$profile.= "<a href=./loginpage.php>$MSG_LOGIN</a>&nbsp;";
				$profile.= "<a href=./registerpage.php>$MSG_REGISTER</a>&nbsp;";
			}
			if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
				$profile.= "<a href=./admin>$MSG_ADMIN</a>&nbsp;";
			
			}
		?>
document.write("<?php echo ( $profile);?>");
