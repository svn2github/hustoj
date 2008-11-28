<?session_start();?>
<title>Submit Code</title>
<?
if (!isset($_SESSION['user_id'])){
	echo "<a href=loginpage.php>Please Login First</a>";
	require_once("oj-footer.php");
	exit(0);
}
if (isset($_GET['id'])){
	$id=intval($_GET['id']);
	require_once("oj-header.php");
}else if (isset($_GET['cid'])&&isset($_GET['pid'])){
	require_once("contest-header.php");
	$cid=intval($_GET['cid']);$pid=intval($_GET['pid']);
}
else{
	echo "<h2>No Such Problem!</h2>";
	require_once("oj-footer.php");
	exit(0);
}
?>
<center>
<form action="submit.php" method="post">
<?if (isset($id)){?>
Problem <font color=blue><b><?=$id?></b></font><br>
<input type='hidden' value='<?=$id?>' name="id">
<?
}else{
$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if ($pid>25) $pid=25;
?>
Problem <font color=blue><b><?=$PID[$pid]?></b></font> of Contest <font color=blue><b><?=$cid?></b></font><br>
<input type='hidden' value='<?=$cid?>' name="cid">
<input type='hidden' value='<?=$pid?>' name="pid">
<?}?>
Language:
<select name="language">
	<option value=0>C</option>
	<option value=1 selected>C++</option>
	<option value=2>Pascal</option>
	<option value=3>Java</option>
</select>
<br>
<textarea cols=80 rows=35 name="source"></textarea><br>
<input type=submit value="Submit">
<input type=reset value="Reset">
</form>
</center>
<?require_once("oj-footer.php")?>

