<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
$cid=intval($_GET['cid']);
	if(!(isset($_SESSION["m$cid"])||isset($_SESSION['administrator']))) exit();
$sql="select `defunct` FROM `contest` WHERE `contest_id`=$cid";
$result=mysqli_query($mysqli,$sql);
$num=mysqli_num_rows($result);
if ($num<1){
	mysqli_free_result($result);
	echo "No Such Contest!";
	require_once("../oj-footer.php");
	exit(0);
}
$row=mysqli_fetch_row($result);
if ($row[0]=='N') $sql="UPDATE `contest` SET `defunct`='Y' WHERE `contest_id`=$cid";
else $sql="UPDATE `contest` SET `defunct`='N' WHERE `contest_id`=$cid";
mysqli_free_result($result);
mysqli_query($mysqli,$sql);
?>
<script language=javascript>
	history.go(-1);
</script>

