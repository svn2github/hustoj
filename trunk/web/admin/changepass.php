<?php require_once("admin-header.php");?>
<?php if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	$user_id=mysql_real_escape_string($_POST['user_id']);
    $passwd =pwGen($_POST['passwd']);
	$sql="update `users` set `password`='$passwd' where `user_id`='$user_id'";
	mysql_query($sql);
	if (mysql_affected_rows()==1) echo "Password Changed!";
	else echo "No such user!";
}
?>
<form action='changepass.php' method=post>
	<b>Change Password:</b><br />
	User:<input type=text size=10 name="user_id"><br />
	Pass:<input type=text size=10 name="passwd"><br />
	<?php require_once("../include/set_post_key.php");?>
	<input type='hidden' name='do' value='do'>
	<input type=submit value='Change'>
</form>
