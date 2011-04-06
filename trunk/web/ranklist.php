<?php
	$now = time ();
	if(isset( $_GET ['start'] ))
		$rank = intval ( $_GET ['start'] );
	else
	    $rank = 0;
	$file = "cache/ranklist$rank.html";
	if (file_exists ( $file ))
		$last = filemtime ( $file );
	else
		$last =0;
	if ($now - $last < 10) {
		//header ( "Location: $file" );
		include ($file);
		exit ();
	} else {
		ob_start ();
		
		
		?>
		<?
		
		require_once ("oj-header.php");
		?>
	<title>Rank List</title>

	<?
		require_once ("./include/db_info.inc.php");
		
		if(isset($OJ_LANG)){
			require_once("./lang/$OJ_LANG.php");
		}
		$page_size=50;
		//$rank = intval ( $_GET ['start'] );
		if ($rank < 0)
			$rank = 0;
		$sql = "SELECT `user_id`,`nick`,`solved`,`submit` FROM `users` ORDER BY `solved` DESC,submit,reg_time  LIMIT  " . strval ( $rank ) . ",$page_size";
		$result = mysql_query ( $sql ); //mysql_error();
		echo "<center><table width=90%>";
		echo "<tr><td colspan=6 align=center>
			<form action=userinfo.php>
				$MSG_USER<input name=user>
				<input type=submit value=Go>
			</form></td></tr>";
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
			echo "<a href=./ranklist.php?start=" . strval ( $i ) . ">";
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
		
		<?
		require_once ("oj-footer.php");
		?>
		<?php
		
		if(!file_exists("cache")) mkdir("cache");
		file_put_contents($file,ob_get_contents ());
		
	}
	
?>
