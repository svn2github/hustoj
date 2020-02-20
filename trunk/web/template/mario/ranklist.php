<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/mario.css'type='text/css'>
</head>
<body>
<div id="wrapper">
	<?php require_once("oj-header.php");?>
<div id=main>
	<table align=center width=90%>
		<thead>
		<tr><td colspan=3 align=left>
			<form action=userinfo.php>
				<?php echo $MSG_USER?><input name=user>
				<input type=submit value=Go>
			</form></td><td colspan=3 align=right>
	                <a href=ranklist.php?scope=d>日排行</a>
			<a href=ranklist.php?scope=w>周排行</a>
			<a href=ranklist.php?scope=m>月排行</a>
			<a href=ranklist.php?scope=y>年排行</a>
			</td></tr>
		<tr class='toprow'>
				<td width=5% align=center><b><?php echo $MSG_Number?></b>
				<td width=10% align=center><b><?php echo $MSG_USER?></b>
				<td width=55% align=center><b><?php echo $MSG_NICK?></b>
				<td width=10% align=center><b><?php echo $MSG_AC?></b>
				<td width=10% align=center><b><?php echo $MSG_SUBMIT?></b>
				<td width=10% align=center><b><?php echo $MSG_RATIO?></b>
		</tr>
		</thead>
		<tbody>
			<?php 
			$cnt=0; $cnt1=0;
			foreach($view_rank as $row){
				if ($cnt) 
					echo "<tr class='oddrow'>";
				else
					echo "<tr class='evenrow'>";
				foreach($row as $table_cell){
					echo "<td>";
					if($cnt==1&&$table_cell==1) echo"<img src='/template/mario/image/red.png' height=43px>";
					else if($cnt==2&&$table_cell==2) echo"<img src='/template/mario/image/logo_l.jpg' height=43px>";
					else if($cnt==3&&$table_cell==3) echo"<img src='/template/mario/image/logo_r.jpg' height=43px>";
					else echo"<img src='/template/mario/image/green.png' height=43px>";
					echo "\t".$table_cell;
					echo "</td>";
				}
				
				echo "</tr>";
				$cnt1=$cnt1+1;
				$cnt=1-$cnt;
			}
			?>
			</tbody>		
	</table>
	<?php 
	   echo "<center>";
		for($i = 0; $i <$view_total ; $i += $page_size) {
			echo "<a href='./ranklist.php?start=" . strval ( $i ).($scope?"&scope=$scope":"") . "'>";
			echo strval ( $i + 1 );
			echo "-";
			echo strval ( $i + $page_size );
			echo "</a>&nbsp;";
			if ($i % 250 == 200)
				echo "<br>";
		}
		echo "</center>";?>
<div id=foot>
	<?php require_once("oj-footer.php");?>
</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
</body>
</html>
