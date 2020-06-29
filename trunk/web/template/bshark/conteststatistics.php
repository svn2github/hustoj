<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_STATISTICS;?> - <?php $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4><?php echo pdo_query('SELECT * FROM `contest` WHERE `contest_id`=?', $cid)[0]['title'];?> - <?php echo $MSG_STATISTICS;?></h4>
    
    <ul class="pagination">
    <li class="page-item"><a class="page-link" href='contest.php?cid=<?php echo $cid?>'><?php echo $MSG_CONTEST;?>C<?php echo $cid;?></a></li>
    <li class="page-item"><a class="page-link" href='status.php?cid=<?php echo $cid?>'><?php echo $MSG_STATUS;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank.php?cid=<?php echo $cid?>'><?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank-oi.php?cid=<?php echo $cid?>'>OI-<?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='conteststatistics.php?cid=<?php echo $cid?>'><?php echo $MSG_STATISTICS;?></a></li>
    </ul>
    <table id=cs class="table table-hover">
<thead>
<tr class=toprow><th><th>AC<th>PE<th>WA<th>TLE<th>MLE<th>OLE<th>RE<th>CE<th><th>TR<th>Total
<?php 
  $i=0;
  foreach ($language_name as $lang){
	if(isset($R[$pid_cnt][$i+11]))	
		echo "<th class='center'>$language_name[$i]</th>";
	else
		echo "<th>";
	$i++;
  }


?>

</tr>
</thead>
<tbody>
<?php
for ($i=0;$i<$pid_cnt;$i++){
if(!isset($PID[$i])) $PID[$i]="";
if ($i&1)
echo "<tr align=center class=oddrow><td>";
else
echo "<tr align=center class=evenrow><td>";
echo "<a href='problem.php?cid=$cid&pid=$i'>$PID[$i]</a>";
for ($j=0;$j<count($language_name)+11;$j++) {
if(!isset($R[$i][$j])) $R[$i][$j]="";
echo "<td>".$R[$i][$j];
}
echo "</tr>";
}
echo "<tr align=center class=evenrow><td>Total";
for ($j=0;$j<count($language_name)+11;$j++) {
if(!isset($R[$i][$j])) $R[$i][$j]="";
echo "<td>".$R[$i][$j];
}
echo "</tr>";
?>
</tbody>
</table>
    </div>
</div>

<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
