<?require_once("admin-header.php");?>
<?
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
if(isset($_GET['uid'])){
	$user_id=mysql_real_escape_string($_GET['uid']);
	$rightstr =$_GET['rightstr'];
	$sql="delete from `privilege` where user_id='$user_id' and rightstr='$rightstr'";
	mysql_query($sql);
	if (mysql_affected_rows()==1) echo "$user_id $rightstr deleted!";
	else echo "No such privilege!";
}
?>

<script language=javascript>
	window.setTimeOut(1000,"history.go(-1)");
</script>
