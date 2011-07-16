<?php require_once("oj-header.php");?>
<title>LOGIN</title>
<br><br>
<?php if (isset($_SESSION['user_id'])){
	echo "<a href=logout.php>Please logout First!</a>";
	exit(1);
}
?>
<form action=login.php method=post>
	<center>
	<table width=400 algin=center>
	<tr><td width=200><?php echo $MSG_USER_ID?>:<td width=200><input name="user_id" type="text" size=20></tr>
	<tr><td><?php echo $MSG_PASSWORD?>:<td><input name="password" type="password" size=20></tr>
	<?php if($OJ_VCODE){?>
		<tr><td><?php echo $MSG_VCODE?>:</td>
			<td><input name="vcode" size=4 type=text><img src=vcode.php>*</td>
		</tr>
		<?php }?>
	<tr><td><td><input name="submit" type="submit" size=10 value="Submit"></tr>
	</table>
	<center>
</form>
<br><br>
<?php require_once("oj-footer.php");?>
