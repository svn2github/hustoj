<?require_once("admin-header.php");
if (!(isset($_SESSION['http_judge']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}?>
<?
if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	$sid=intval($_POST['sid']);
	$result=intval($_POST['result']);
	$time=intval($_POST['time']);
	$memory=intval($_POST['memory']);
	$sim=intval($_POST['sim']);
	$simid=intval($_POST['simid']);
	$sql="UPDATE solution SET result=$result,time=$time,memory=$memory,judgetime=NOW() WHERE solution_id=$sid LIMIT 1";
	echo $sql;
	mysql_query($sql);
	
    if ($sim) {
		$sql="insert into sim(s_id,sim_s_id,sim) values($sid,$simid,$sim) on duplicate key update  sim_s_id=$simid,sim=$sim";
		mysql_query($sql);
	}
	
}
?>
<form action='problem_judge.php' method=post>
	<b>HTTP Judge:</b><br />
	sid:<input type=text size=10 name="sid" value=1244><br />
	result:<input type=text size=10 name="result" value=4><br />
	time:<input type=text size=10 name="time" value=500><br />
	memory:<input type=text size=10 name="memory" value=1024><br />
	sim:<input type=text size=10 name="sim" value=100><br />
	simid:<input type=text size=10 name="simid" value=0><br />
	
	<input type='hidden' name='do' value='do'>
	<?require_once("../include/set_post_key.php");?>
	<input type=submit value='Judge'>
</form>
