<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php $id=intval($_GET['id']);
$sql="SELECT `defunct` FROM `problem` WHERE `problem_id`=$id";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_row($result);
$defunct=$row[0];
echo $defunct;
mysqli_free_result($result);
if ($defunct=='Y') $sql="update `problem` set `defunct`='N' where `problem_id`=$id";
else $sql="update `problem` set `defunct`='Y' where `problem_id`=$id";
mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<script language=javascript>
	history.go(-1);
</script>
