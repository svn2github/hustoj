<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
$cid=$_GET['cid'];
echo $cid;
if(!(isset($_SESSION[$OJ_NAME.'_'."m$cid"])||isset($_SESSION[$OJ_NAME.'_'.'administrator']))) exit();
$sql="select `defunct` FROM `users` WHERE `user_id`=?";
$result=pdo_query($sql,$cid);
echo $result;
$num=count($result);
if ($num<1){
	echo "No Such User!";
	require_once("../oj-footer.php");
	exit(0);
}
$row=$result[0];
if ($row[0]=='N') 
	$sql="UPDATE `users` SET `defunct`='Y' WHERE `user_id`=?";
else 
	$sql="UPDATE `users` SET `defunct`='N' WHERE `user_id`=?";
pdo_query($sql,$cid);
?>
<script language=javascript>
	history.go(-1);
</script>

