<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
$cid=intval($_GET['cid']);
	if(!(isset($_SESSION["m$cid"])||isset($_SESSION['administrator']))) exit();
$sql="select `private` FROM `contest` WHERE `contest_id`=$cid";
$result=pdo_query($sql);
$num=count($result);
if ($num<1){
	
	echo "No Such Problem!";
	require_once("../oj-footer.php");
	exit(0);
}
$row=$result[0];
if (intval($row[0])==0) $sql="UPDATE `contest` SET `private`='1' WHERE `contest_id`=$cid";
else $sql="UPDATE `contest` SET `private`='0' WHERE `contest_id`=$cid";

pdo_query($sql);
?>
<script language=javascript>
	history.go(-1);
</script>

