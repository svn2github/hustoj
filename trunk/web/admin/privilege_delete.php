<?php require_once("admin-header.php");?>
<?php require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
if(isset($_GET['uid'])){
	$user_id=mysqli_real_escape_string($mysqli,$_GET['uid']);
	$rightstr =mysqli_real_escape_string($mysqli,$_GET['rightstr']);
	$sql="delete from `privilege` where user_id='$user_id' and rightstr='$rightstr'";
	mysqli_query($mysqli,$sql);
	if (mysqli_affected_rows($mysqli)==1) echo "$user_id $rightstr deleted!";
	else echo "No such privilege!";
}
?>

<script language=javascript>
	window.setTimeOut(1000,"history.go(-1)");
</script>
