<?require("admin-header.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}?>
<?
if(isset($_POST['do'])){
	if (isset($_POST['rjpid'])){
		$sql="UPDATE `solution` SET `result`=1 WHERE `problem_id`=".$_POST['rjpid'];
		mysql_query($sql) or die(mysql_error());
		$sql="delete from `sim` WHERE `s_id` in (select solution_id from solution where `problem_id`=".$_POST['rjpid'].")";
		mysql_query($sql) or die(mysql_error());
		$url="../status.php?problem_id=".$_POST['rjpid'];
		echo "Rejudged Problem ".$_POST['rjpid'];
		echo "<script>location.href='$url';</script>";
	}
	else if (isset($_POST['rjsid'])){
		$sql="UPDATE `solution` SET `result`=1 WHERE `solution_id`=".$_POST['rjsid'];
		mysql_query($sql) or die(mysql_error());
		$sql="delete from `sim` WHERE `s_id`=".$_POST['rjsid'];
		mysql_query($sql) or die(mysql_error());
		$url="../status.php?top=".(intval($_POST['rjsid'])+1);
		echo "Rejudged Runid ".$_POST['rjsid'];
		echo "<script>location.href='$url';</script>";
	}
}
?>
<b>Rejudge</b>
	<ol>
	<li>Problem
	<form action='rejudge.php' method=post>
		<input type=input name='rjpid'>	<input type='hidden' name='do' value='do'>
		<input type=submit value=submit>
	</form>
	<li>Solution
	<form action='rejudge.php' method=post>
		<input type=input name='rjsid'>	<input type='hidden' name='do' value='do'>
		<input type=submit value=submit>
	</form>
