<?require_once("admin-header.php");?>
<?
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
if(isset($_POST['do'])){
	$user_id=mysql_real_escape_string($_POST['user_id']);
	$passwd =MD5($_POST['passwd']);
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
	<input type='hidden' name='do' value='do'>
	<input type=submit value='Change'>
</form>
