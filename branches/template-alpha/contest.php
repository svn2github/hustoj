<?php
	$OJ_CACHE_SHARE=!isset($_GET['cid']);
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= $MSG_CONTEST;

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
				$description=$row->description;
				echo "<title>Contest - $row->title</title>";
				echo "<h3>Contest - $row->title</h3>
					
						<p>$description</p>
						<br>Start Time: <font color=#993399>$row->start_time</font> ";
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
			echo "<table id=problemset  width=80%><tr class=toprow><td width=5><td width=34%><b>Problem ID</b><td width=65%><b>Title</b></tr>";
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

		    $sql="SELECT * FROM `contest` WHERE `defunct`='N' ORDER BY `contest_id` DESC";
			$result=mysql_query($sql);
			
			$view_contest=Array();
			$i=0;
			while ($row=mysql_fetch_object($result)){
				
				$view_contest[$i][0]= $row->contest_id;
				$view_contest[$i][1]= "<a href='contest.php?cid=$row->contest_id'>$row->title</a>";
				$start_time=strtotime($row->start_time);
				$end_time=strtotime($row->end_time);
				$now=time();
				// past
				if ($now>$end_time) 
					$view_contest[$i][2]= "<span class=green>Ended@$row->end_time</span>";
				// pending
				else if ($now<$start_time) 
					$view_contest[$i][2]=  "<span class=blue>Start@$row->start_time</span>";
				// running
				else 
					$view_contest[$i][3]= "<span class=red> Running </span>";
				$private=intval($row->private);
				if ($private==0) 
					$view_contest[$i][4]= "<span class=blue>Public</span>";
				else 
					$view_contest[$i][5]= "<span class=red>Private</span>";
				
			
				$i++;
			}
			
			mysql_free_result($result);

}


/////////////////////////Template
if(isset($_GET['cid']))
	require("template/".$OJ_TEMPLATE."/contest.html");
else
	require("template/".$OJ_TEMPLATE."/contestset.html");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>