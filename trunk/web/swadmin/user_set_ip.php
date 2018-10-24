<?php require("admin-header.php");

        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }

echo "<title>User List</title>";
echo "<hr>";
echo "<center><h2>$MSG_SET_LOGIN_IP</h2></center>";
require_once("../include/set_get_key.php");
$sql="";
if(isset($_POST['user_id'])){
	require_once("../include/check_post_key.php");
	$user_id=$_POST['user_id'];
	$ip=$_POST['ip'];
	 $sql="insert into loginlog (user_id,password,ip,time) value(?,?,?,now())";
	 $result=pdo_query($sql,$user_id,"set ip by ".$_SESSION[$OJ_NAME."_user_id"],$ip);
	echo "$MSG_USER ".htmlentities($user_id)." $MSG_SET_LOGIN_IP : ".htmlentities($ip);
}
?>
<form action=user_set_ip.php class=center method="post">
<?php echo $MSG_USER?>	
	<input type="text" name="user_id" ><br>
	IP:<input type="text" name="ip" ><br>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value="<?php echo $MSG_ADD?>" ></form>

<?php
require("../oj-footer.php");
?>
