<?require_once("./include/db_info.inc.php");
	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
?>

<?require_once("./include/my_func.inc.php")?>
<?require_once("./include/const.inc.php")?>
<?
if (isset($_GET['cid'])){
	$cid=intval($_GET['cid']);
//	print $cid;
	require_once("contest-header.php");
	// check contest valid
	$sql="SELECT * FROM `contest` WHERE `contest_id`='$cid' AND `defunct`='N' ";
	$result=mysql_query($sql);
	$rows_cnt=mysql_num_rows($result);
	echo "<center>";
	if ($rows_cnt==0){
		mysql_free_result($result);
		echo "<h2>No Such Contest!</h2>";
		require_once("oj-footer.php");
		exit(0);
	}else{
		$row=mysql_fetch_object($result);
		$now=time();
		$start_time=strtotime($row->start_time);
		$end_time=strtotime($row->end_time);
		echo "<title>Contest - $row->title</title>";
		echo "<h3>Contest - $row->title</h3>Start Time: <font color=#993399>$row->start_time</font> ";
		echo "End Time: <font color=#993399>$row->end_time</font><br>";
		echo "Current Time: <font color=#993399><span id=nowdate >".date("Y-m-d H:i:s")."</span></font> Status:";
		if ($now>$end_time) echo "<font color=red>Ended</font>";
		else if ($now<$start_time) echo "<font color=red>Not Started</font>";
		else echo "<font color=red>Running</font>";
		if ($row->private=='0') echo "&nbsp;&nbsp;<font color=blue>Public</font>";
		else echo "&nbsp;&nbsp;<font color=red>Private</font>"; 
		if (!isset($_SESSION['administrator']) && $now<$start_time){
			echo "</center>";
			require_once("oj-footer.php");
			exit(0);
		}
	}
	if (!$contest_ok){
		echo "<br><h1>Not Invited!</h1>";
		require_once("oj-footer.php");
		exit(1);
	}
	$sql="SELECT `problem`.`title` as `title`,`problem`.`problem_id` as `pid`
		FROM `contest_problem`,`problem`
		WHERE `contest_problem`.`problem_id`=`problem`.`problem_id` AND `problem`.`defunct`='N'
		AND `contest_problem`.`contest_id`='$cid' ORDER BY `contest_problem`.`num`";
//	echo $cid;
//	echo "<br>";
//	echo $sql;
//	echo "<br>";
	$result=mysql_query($sql);
	$cnt=0;
	echo "<table width=60%><tr class=toprow><td width=5><td width=34%><b>Problem ID</b><td width=65%><b>Title</b></tr>";
	while ($row=mysql_fetch_object($result)){
		if ($cnt&1) echo "<tr class=oddrow>";
		else echo "<tr class=evenrow>";
		echo "<td>";
		if (isset($_SESSION['user_id'])) echo check_ac($cid,$cnt);
		echo "<td>$row->pid Problem $PID[$cnt]
			<td><a href='problem.php?cid=$cid&pid=$cnt'>$row->title</a>
			</tr>";
		$cnt++;
	}
	echo "</table><br>";
	mysql_free_result($result);
	echo "[<a href='status.php?cid=$cid'>Status</a>]";
	echo "[<a href='contestrank.php?cid=$cid'>Standing</a>]";
	echo "[<a href='conteststatistics.php?cid=$cid'>Statistics</a>]";
	echo "</center>";
}else{
require_once("oj-header.php");
?>
<title>Contest List</title>
<?
$sql="SELECT * FROM `contest` WHERE `defunct`='N' ORDER BY `contest_id` DESC";
$result=mysql_query($sql);
$color=false;
echo "<center><table width=90%><h2>Contest List</h2>ServerTime:<span id=nowdate></span>";
echo "<tr class=toprow align=center><td width=10%>ID<td width=50%>Name<td width=30%>Status<td width=10%>Private</tr>";
while ($row=mysql_fetch_object($result)){
	if ($color) echo "<tr align=center class=oddrow>";
	else echo "<tr align=center class=evenrow>";
	echo "<td>$row->contest_id";
	echo "<td><a href='contest.php?cid=$row->contest_id'>$row->title</a>";
	$start_time=strtotime($row->start_time);
	$end_time=strtotime($row->end_time);
	$now=time();
	// past
	if ($now>$end_time) echo "<td><font color=green>Ended@$row->end_time</font>";
	// pending
	else if ($now<$start_time) echo "<td><font color=blue>Start@$row->start_time</font>";
	// running
	else echo "<td><font color=red> Running </font>";
	$private=intval($row->private);
	if ($private==0) echo "<td><font color=blue>Public</font>";
	else echo "<td><font color=red>Private</font>";
	echo "</tr>";
	$color=!$color;
}
echo "</table></center>";
mysql_free_result($result);
?>

<?
}
require_once("oj-footer.php");
?>
<script>
var diff=new Date("<?=date("Y/m/d H:i:s")?>").getTime()-new Date().getTime();
//alert(diff);
function clock()
    {
      var x,h,m,s,n,xingqi,y,mon,d;
      var x = new Date(new Date().getTime()+diff);
      y = x.getYear()+1900;
      mon = x.getMonth()+1;
      d = x.getDate();
      xingqi = x.getDay();
      h=x.getHours();
      m=x.getMinutes();
      s=x.getSeconds();
  
      n=y+"-"+mon+"-"+d+" "+(h>=10?h:"0"+h)+":"+(m>=10?m:"0"+m)+":"+(s>=10?s:"0"+s);
      //alert(n);
      document.getElementById('nowdate').innerHTML=n;
      setTimeout("clock()",1000);
    } 
    clock();
</script>
