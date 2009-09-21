<?require("admin-header.php");?>
<?
if($_POST['do']=='do'){
	if (isset($_POST['rjpid'])){
		$sql="UPDATE `solution` SET `result`=1 WHERE `problem_id`=".$_POST['rjpid'];
		mysql_query($sql) or die(mysql_error());
		echo "Rejudged Problem ".$_POST['rjpid'];
	}
	else if (isset($_POST['rjsid'])){
		$sql="UPDATE `solution` SET `result`=1 WHERE `solution_id`=".$_POST['rjsid'];
		mysql_query($sql) or die(mysql_error());
		echo "Rejudged Runid ".$_POST['rjsid'];
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