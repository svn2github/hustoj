<?php 
require_once("oj-header.php");
require_once("include/db_info.inc.php");

?>
<title>Register Page</title>
<form action="register.php" method="post">
	<br><br>
	<center><table>
		<tr><td colspan=2 height=40 width=500>&nbsp;&nbsp;&nbsp;<?php echo $MSG_REG_INFO?></tr>
		<tr><td width=25%><?php echo $MSG_USER_ID?>:
			<td width=75%><input name="user_id" size=20 type=text>*
		</tr>
		<tr><td><?php echo $MSG_NICK?>:
			<td><input name="nick" size=50 type=text>
		</tr>
		<tr><td><?php echo $MSG_PASSWORD?>:
			<td><input name="password" size=20 type=password>*
		</tr>
		<tr><td><?php echo $MSG_REPEAT_PASSWORD?>:
			<td><input name="rptpassword" size=20 type=password>*
		</tr>
		<tr><td><?php echo $MSG_SCHOOL?>:
			<td><input name="school" size=30 type=text>
		</tr>
		<tr><td><?php echo $MSG_EMAIL?>:
			<td><input name="email" size=30 type=text>
		</tr>
		<?php if($OJ_VCODE){?>
		<tr><td>TYPE:<img src=vcode.php>
			<td><input name="vcode" size=4 type=text>*
		</tr>
		<?php }?>
		<tr><td>
			<td><input value="Submit" name="submit" type="submit">
				&nbsp; &nbsp;
				<input value="Reset" name="reset" type="reset">
		</tr>
	</table></center>
	<br><br>
</form>
<?php require_once("oj-footer.php");?>
