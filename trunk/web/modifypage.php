<?require_once('oj-header.php');?>
<title>Update Information</title>
<?
if (!isset($_SESSION['user_id'])){
	echo "<a href=./loginpage.php>Please LogIn First!</a>";
	require_once('oj-footer.php');
	exit();
}
require_once('./include/db_info.inc.php');
$sql="SELECT `school`,`nick`,`email` FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
?>
<form action="modify.php" method="post">
	<br><br>
	<center><table>
		<tr><td colspan=2 height=40 width=500>&nbsp;&nbsp;&nbsp;Update Information</tr>
		<tr><td width=25%>User ID:
			<td width=75%><?=$_SESSION['user_id']?>
			<?require_once('./include/set_post_key.php');?>
		</tr>
		<tr><td>Nick Name:
			<td><input name="nick" size=50 type=text value="<?=htmlspecialchars($row->nick)?>" >
		</tr>
		<tr><td>Old Password:
			<td><input name="opassword" size=20 type=password>
		</tr>
		<tr><td>New Password:
			<td><input name="npassword" size=20 type=password>
		</tr>
		<tr><td>Repeat New Password::
			<td><input name="rptpassword" size=20 type=password>
		</tr>
		<tr><td>School:
			<td><input name="school" size=30 type=text value="<?=htmlspecialchars($row->school)?>" >
		</tr>
		<tr><td>Email:
			<td><input name="email" size=30 type=text value="<?=htmlspecialchars($row->email)?>" >
		</tr>
		<tr><td>
			<td><input value="Submit" name="submit" type="submit">
				&nbsp; &nbsp;
				<input value="Reset" name="reset" type="reset">
		</tr>
	</table></center>
	<br><br>
<?
mysql_free_result($result);
?>
<?require_once('oj-footer.php');?>
