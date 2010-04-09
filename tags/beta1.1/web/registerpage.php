<?require_once("oj-header.php");?>
<title>Register Page</title>
<form action="register.php" method="post">
	<br><br>
	<center><table>
		<tr><td colspan=2 height=40 width=500>&nbsp;&nbsp;&nbsp;Register Information</tr>
		<tr><td width=25%>User ID:
			<td width=75%><input name="user_id" size=20 type=text>
		</tr>
		<tr><td>Nick Name:
			<td><input name="nick" size=50 type=text>
		</tr>
		<tr><td>Password:
			<td><input name="password" size=20 type=password>
		</tr>
		<tr><td>Repeat Password::
			<td><input name="rptpassword" size=20 type=password>
		</tr>
		<tr><td>School:
			<td><input name="school" size=30 type=text>
		</tr>
		<tr><td>Email:
			<td><input name="email" size=30 type=text>
		</tr>
		<tr><td>
			<td><input value="Submit" name="submit" type="submit">
				&nbsp; &nbsp;
				<input value="Reset" name="reset" type="reset">
		</tr>
	</table></center>
	<br><br>
</form>
<?require_once("oj-footer.php");?>
