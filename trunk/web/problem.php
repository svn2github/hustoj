<?require_once("./include/db_info.inc.php")?>

<?
$pr_flag=false;
$co_flag=false;
if (isset($_GET['id'])){
	// practice
	$id=intval($_GET['id']);
	require_once("oj-header.php");
	if (!isset($_SESSION['administrator']) && $id!=1000)
		$sql="SELECT * FROM `problem` WHERE `problem_id`=$id AND `defunct`='N' AND `problem_id` NOT IN (
				SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
						SELECT `contest_id` FROM `contest` WHERE `end_time`>NOW() or `private`='1'))
                                ";
	else
		$sql="SELECT * FROM `problem` WHERE `problem_id`=$id";

	$pr_flag=true;
}else if (isset($_GET['cid']) && isset($_GET['pid'])){
	// contest
	$cid=$_GET['cid'];
	$pid=$_GET['pid'];

	if (!isset($_SESSION['administrator']))
		$sql="SELECT langmask FROM `contest` WHERE `defunct`='N' AND `contest_id`=$cid AND `start_time`<NOW()";
	else
		$sql="SELECT langmask FROM `contest` WHERE `defunct`='N' AND `contest_id`=$cid";
	$result=mysql_query($sql);
	$rows_cnt=mysql_num_rows($result);
   $ok_cnt=$rows_cnt==1;		
	$row=mysql_fetch_row($result);
	$langmask=$row[0];
	mysql_free_result($result);
	if ($ok_cnt!=1){
		// not started
		echo "No such Contest!";
		require_once("oj-footer.php");
		exit(0);
	}else{
		// started
		$sql="SELECT * FROM `problem` WHERE `defunct`='N' AND `problem_id`=(
			SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=$cid AND `num`=$pid
			)";
	}
	// public
	require_once("contest-header.php");
	if (!$contest_ok){
		echo "Not Invited!";
		require_once("oj-footer.php");
		exit(1);
	}
	$co_flag=true;
}else{
	require_once("oj-header.php");
	echo "<title>No Such Problem!</title><h2>No Such Problem!</h2>";
	require_once("oj-footer.php");
	exit(0);
}
$result=mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($result)!=1){
   if(isset($_GET['id'])){
      $id=$_GET['id'];
	   mysql_free_result($result);
	   $sql="SELECT  contest.`contest_id` , contest.`title`,contest_problem.num FROM `contest_problem`,`contest` WHERE contest.contest_id=contest_problem.contest_id and `problem_id`=$id and defunct='N'  ORDER BY `num`";
	   //echo $sql;
           $result=mysql_query($sql);
	   if($i=mysql_num_rows($result)){
	      echo "This problem is in Contest(s) below:<br>";
		   for (;$i>0;$i--){
				$row=mysql_fetch_row($result);
				echo "<a href=problem.php?cid=$row[0]&pid=$row[2]>Contest $row[0]:$row[1]</a><br>";
				
			}
		}else{
			echo "<title>No Such Problem!</title>";
			echo "<h2>No Such Problem!</h2>";
		}
   }else{
		echo "<title>No Such Problem!</title>";
		echo "<h2>No Such Problem!</h2>";
	}
}else{
	$row=mysql_fetch_object($result);
	if ($pr_flag){
		echo "<title>Problem $row->problem_id. -- $row->title</title>";
		echo "<center><h2>$row->title</h2>";
	}else{
		$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		echo "<title>Problem $PID[$pid]: $row->title </title>";
		echo "<center><h2>Problem $PID[$pid]: $row->title</h2>";
	}
	echo "<b>Time Limit: </b>$row->time_limit Sec&nbsp;&nbsp;";
	echo "<b>Memory Limit: </b>".$row->memory_limit." MB<br>";
	echo "<b>Submissions: </b>".$row->submit."&nbsp;&nbsp;";
	echo "<b>Solved: </b>".$row->accepted."<br>"; 
	
	if ($pr_flag){
		echo "[<a href='submitpage.php?id=$id'>Submit</a>]";
	}else{
		echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>Submit</a>]";
	}
	echo "[<a href='problemstatus.php?id=".$row->problem_id."'>Status</a>]";
	echo "[<a href='bbs.php?id=".$row->problem_id."'>Discuss</a>]";
	
	echo "</center>";
	
	echo "<h2>Description</h2><p>".$row->description."</p>";
	echo "<h2>Input</h2><p>".$row->input."</p>";
	echo "<h2>Output</h2><p>".$row->output."</p>";
	echo "<h2>Sample Input</h2><pre>".htmlspecialchars($row->sample_input)."</pre>";
	echo "<h2>Sample Output</h2><pre>".htmlspecialchars($row->sample_output)."</pre>";
	if ($pr_flag||true) echo "<h2>HINT</h2><p>".nl2br($row->hint)."</p>";
	if ($pr_flag) echo "<h2>Source</h2><p><a href='problemset.php?search=$row->source'>".nl2br($row->source)."</a></p>";
	echo "<center>";
	if ($pr_flag){
		echo "[<a href='submitpage.php?id=$id'>Submit</a>]";
	}else{
		echo "[<a href='submitpage.php?cid=$cid&pid=$pid&langmask=$langmask'>Submit</a>]";
	}
	echo "[<a href='problemstatus.php?id=".$row->problem_id."'>Status</a>]";
	echo "[<a href='bbs.php?id=".$row->problem_id."'>Discuss</a>]";
	echo "</center>";
}
mysql_free_result($result);
?>
<?require_once("oj-footer.php")?>
