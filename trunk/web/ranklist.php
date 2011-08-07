<?php
	$OJ_CACHE_SHARE=false;
	$cache_time=30;
	$scope="";
	if(isset($_GET['scope']))
		$scope=$_GET['scope'];
	if($scope!=""&&$scope!='d'&&$scope!='w'&&$scope!='m')
		$scope='y';
		
	$rank = 0;
	if(isset( $_GET ['start'] ))
		$rank = intval ( $_GET ['start'] );

		
		?>
		<?php require_once ("oj-header.php");
		?>
	<title>Rank List</title>

	<?php require_once ("./include/db_info.inc.php");
		
		if(isset($OJ_LANG)){
			require_once("./lang/$OJ_LANG.php");
		}
		$page_size=50;
		//$rank = intval ( $_GET ['start'] );
		if ($rank < 0)
			$rank = 0;
			
		$sql = "SELECT `user_id`,`nick`,`solved`,`submit` FROM `users` ORDER BY `solved` DESC,submit,reg_time  LIMIT  " . strval ( $rank ) . ",$page_size";
		
		if($scope){
			$s="";
			switch ($scope){
				case 'd': 
					$s=date('Y').'-'.date('m').'-'.date('d');
					break;
				case 'w': 
					$monday=mktime(0, 0, 0, date("m"),date("d")-(date("w")+7)%8+1, date("Y"));
					//$monday->subDays(date('w'));
					$s=strftime("%Y-%m-%d",$monday);
					break;
				case 'm': 
					$s=date('Y').'-'.date('m').'-01';
					;break;
				default : 
					$s=date('Y').'-01-01';
			}
			//echo $s."<-------------------------";
			$sql="SELECT users.`user_id`,`nick`,s.`solved`,t.`submit` FROM `users` 
					right join 
					(select count(distinct problem_id) solved ,user_id from solution where in_date>'$s' and result=4 group by user_id order by solved desc limit " . strval ( $rank ) . ",$page_size) s on users.user_id=s.user_id
					left join 
					(select count( problem_id) submit ,user_id from solution where in_date>'$s' group by user_id order by submit desc limit " . strval ( $rank ) . ",".($page_size*2).") t on users.user_id=t.user_id
				ORDER BY s.`solved` DESC,t.submit,reg_time  LIMIT  0,50
			 ";
			 //echo $sql;
		}
		
		
		$result = mysql_query ( $sql ); //mysql_error();
		echo "<center><table width=90%>";
		echo "<tr><td colspan=3 align=left>
			<form action=userinfo.php>
				$MSG_USER<input name=user>
				<input type=submit value=Go>
			</form></td><td colspan=3 align=right>
			<a href=ranklist.php?scope=d>Day</a>
			<a href=ranklist.php?scope=w>Week</a>
			<a href=ranklist.php?scope=m>Month</a>
			<a href=ranklist.php?scope=y>Year</a>
			</td></tr>";
		echo "<tr class='toprow'>
				<td width=5% align=center><b>$MSG_Number</b>
				<td width=10% align=center><b>$MSG_USER</b>
				<td width=55% align=center><b>$MSG_NICK</b>
				<td width=10% align=center><b>$MSG_AC</b>
				<td width=10% align=center><b>$MSG_SUBMIT</b>
				<td width=10% align=center><b>$MSG_RATIO</b></tr>";
		while ( $row = mysql_fetch_object ( $result ) ) {
			$rank ++;
			if ($rank % 2 == 1)
				echo "<tr class='oddrow'>";
			else
				echo "<tr class='evenrow'>";
			echo "<td align=center>" . $rank;
			echo "<td align=center><a href='userinfo.php?user=" . $row->user_id . "'>" . $row->user_id . "</a>";
			echo "<td align=center>" . htmlspecialchars ( $row->nick );
			echo "<td align=center><a href='status.php?user_id=" . $row->user_id . "&jresult=4'>" . $row->solved . "</a>";
			echo "<td align=center><a href='status.php?user_id=" . $row->user_id . "'>" . $row->submit . "</a>";
			//		echo "<td align=center>".$row->submit;
			echo "<td align=center>";
			if ($row->submit == 0)
				echo "0.000%";
			else
				echo sprintf ( "%.03lf%%", 100 * $row->solved / $row->submit );
			echo "</tr>";
		}
		echo "</table></center>";
		mysql_free_result ( $result );
		$sql = "SELECT count(*) as `mycount` FROM `users`";
		$result = mysql_query ( $sql );
		echo mysql_error ();
		$row = mysql_fetch_object ( $result );
		echo "<center>";
		for($i = 0; $i < $row->mycount; $i += $page_size) {
			echo "<a href='./ranklist.php?start=" . strval ( $i ).($scope?"&scope=$scope":"") . "'>";
			echo strval ( $i + 1 );
			echo "-";
			echo strval ( $i + $page_size );
			echo "</a>&nbsp;";
			if ($i % 250 == 200)
				echo "<br>";
		}
		echo "</center>";
		mysql_free_result ( $result );
		?>
		
<?php require_once ("oj-footer.php");?>
