<?php require_once("../include/db_info.inc.php");
if (!(isset($_SESSION['http_judge']))){
	echo "0";
	exit(1);
}?>
<?php if(isset($_POST['update_solution'])){
	//require_once("../include/check_post_key.php");
	$sid=intval($_POST['sid']);
	$result=intval($_POST['result']);
	$time=intval($_POST['time']);
	$memory=intval($_POST['memory']);
	$sim=intval($_POST['sim']);
	$simid=intval($_POST['simid']);
	$sql="UPDATE solution SET result=?,time=?,memory=?,judgetime=NOW() WHERE solution_id=? LIMIT 1";
	echo $sql;
	pdo_query($sql,$result,$time,$memory,$sid);
	
    if ($sim) {
		$sql="insert into sim(s_id,sim_s_id,sim) values(?,?,?) on duplicate key update  sim_s_id=?,sim=?";
		pdo_query($sql,$sid,$simid,$sim,$simid,$sim);
	}
	
}else if(isset($_POST['checkout'])){
	
	$sid=intval($_POST['sid']);
	$result=intval($_POST['result']);
	$sql="UPDATE solution SET result=?,time=0,memory=0,judgetime=NOW() WHERE solution_id=? and result<2 LIMIT 1";
	
	if(pdo_query($sql,$result,$sid)>0)
		echo "1";
	else
		echo "0";
}else if(isset($_POST['getpending'])){
	$max_running=intval($_POST['max_running']);
	$sql="SELECT solution_id FROM solution WHERE result<2  ORDER BY result ASC,solution_id ASC limit ?";
	$result=pdo_query($sql,$max_running);
	 foreach($result as $row){
		echo $row['solution_id']."\n";
	}
	
	
}else if(isset($_POST['getsolutioninfo'])){
	
	$sid=intval($_POST['sid']);
	$sql="select problem_id, user_id, language from solution WHERE solution_id=? ";
	$result=pdo_query($sql,$sid);
	if ( $row=$result[0]){
		echo $row['problem_id']."\n";
		echo $row['user_id']."\n";
		echo $row['language']."\n";
		
	}
	
	
}else if(isset($_POST['getsolution'])){
	
	$sid=intval($_POST['sid']);
	$sql="SELECT source FROM source_code WHERE solution_id=$sid ";
	$result=pdo_query($sql);
	if ( $row=$result[0]){
		echo $row['source']."\n";
	}
	
	
}else if(isset($_POST['getprobleminfo'])){
	
	$pid=intval($_POST['pid']);
	$sql="SELECT time_limit,memory_limit,spj FROM problem where problem_id=$pid ";
	$result=pdo_query($sql);
	if ( $row=$result[0]){
		echo $row['time']_limit."\n";
		echo $row['memory']_limit."\n";
		echo $row->spj."\n";
		
	}
	
	
}else if(isset($_POST['addceinfo'])){
	
	$sid=intval($_POST['sid']);
	$sql="DELETE FROM compileinfo WHERE solution_id=? ";
	pdo_query($sql,$sid);
	
	$sql="INSERT INTO compileinfo VALUES($sid,?)";
	pdo_query($sql,$ceinfo);
	
}else if(isset($_POST['updateuser'])){
	
	
	$sql="UPDATE `users` SET `solved`=(SELECT count(DISTINCT `problem_id`) FROM `solution` WHERE `user_id`=? AND `result`=\'4\') WHERE `user_id`=?";
	pdo_query($sql,$user_id,$user_id);
	
	$sql="UPDATE `users` SET `submit`=(SELECT count(*) FROM `solution` WHERE `user_id`=?) WHERE `user_id`=?";
	pdo_query($sql,$user_id,$user_id);
	
}else if(isset($_POST['updateproblem'])){
	
	$pid=intval($_POST['pid']);
	$sql="UPDATE `problem` SET `accepted`=(SELECT count(*) FROM `solution` WHERE `problem_id`=? AND `result`=\'4\') WHERE `problem_id`=?";
	pdo_query($sql,$pid,$pid);
	
	$sql="UPDATE `problem` SET `submit`=(SELECT count(*) FROM `solution` WHERE `problem_id`=?) WHERE `problem_id`=?";
	pdo_query($sql,$pid,$pid);
	
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
	
	<input type='hidden' name='update_solution' value='do'>
	<?php require_once("../include/set_post_key.php");?>
	<input type=submit value='Judge'>
</form>
<?php }
?>
