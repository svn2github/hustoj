<?require("admin-header.php");?>
<?
if (isset($_POST['rjpid'])){
	$sql="UPDATE `solution` SET `result`=1 WHERE `problem_id`=".$_POST['rjpid'];
	mysql_query($sql) or die(mysql_error());
	echo "Rejudged Problem ".$_POST['rjpid'];
}
else if (isset($_POST['rjsid'])){
	$sql="UPDATE `solution` SET `result`=1 WHERE `solution_id`=".$_POST['rjsid'];
	mysql_query($sql) or die(mysql_error());
	echo "Rejudged Runid ".$_POST['rsid'];
}
?>
