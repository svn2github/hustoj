<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php $id=intval($_GET['id']);
$sql="SELECT `defunct` FROM `news` WHERE `news_id`=$id";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_row($result);
$defunct=$row[0];
echo $defunct;
mysqli_free_result($result);
if ($defunct=='Y') $sql="update `news` set `defunct`='N' where `news_id`=$id";
else $sql="update `news` set `defunct`='Y' where `news_id`=$id";
mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<script language=javascript>
	history.go(-1);
</script>
