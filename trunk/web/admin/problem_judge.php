<?require_once("../include/db_info.inc.php");
if (!(isset($_SESSION['http_judge']))){
	echo "0";
	exit(1);
}?>
<?
if(isset($_POST['judge'])){
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
	
}else if(isset($_POST['checkout'])){
	
	$sid=intval($_POST['sid']);
	$result=intval($_POST['result']);
	$sql="UPDATE solution SET result=$result,time=0,memory=0,judgetime=NOW() WHERE solution_id=$sid and result<2 LIMIT 1";
	mysql_query($sql);
	if(mysql_affected_rows()>0)
		echo "1";
	else
		echo "0";
}else if(isset($_POST['checklogin'])){
	echo "1";
}else{
?>

<form action='problem_judge.php' method=post>
	<b>HTTP Judge:</b><br />
	sid:<input type=text size=10 name="sid" value=1244><br />
	result:<input type=text size=10 name="result" value=4><br />
	time:<input type=text size=10 name="time" value=500><br />
	memory:<input type=text size=10 name="memory" value=1024><br />
	sim:<input type=text size=10 name="sim" value=100><br />
	simid:<input type=text size=10 name="simid" value=0><br />
	
	<input type='hidden' name='judge' value='do'>
	<?require_once("../include/set_post_key.php");?>
	<input type=submit value='Judge'>
</form>
<?
}
?>
