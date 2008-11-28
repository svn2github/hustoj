<?require_once("admin-header.php");?>
<title>Admin Index</title>
<center><h1>Admin Index Page</h1></center>
<hr>
<ol>
<li>
	<form action='changepass.php' method=post>
	<b>Change Password:</b>
	User:<input type=text size=10 name="user_id">
	Pass:<input type=text size=10 name="passwd">
	<input type=submit value='Change'>
	</form>
<li>
	<a href="addproblempage.php"><b>Add A New Problem</b></a>
<li>
	<a href="addcontest.php"><b>Add A Contest</b></a>
<li>
	<a href="problemlist.php"><b>ProblemList</b></a>
<li>
	<a href="contestlist.php"><b>ContestList</b></a>
<li>
	<b>Set Message</b>
	<form action='setmsg.php' method='post'>
		<textarea name='msg' rows=3 cols=60></textarea><br>
		<input type='submit' value='change'>
	</form>
<li>
	<b>Rejudge</b>
	<ol>
	<li>Problem
	<form action='rejudge.php' method=post>
		<input type=input name='rjpid'>
		<input type=submit value=submit>
	</form>
	<li>Solution
	<form action='rejudge.php' method=post>
		<input type=input name='rjsid'>
		<input type=submit value=submit>
	</form>
	</ol>
</ol>
<?require_once("../oj-footer.php");?>
