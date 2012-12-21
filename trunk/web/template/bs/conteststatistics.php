<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv='refresh' content='60'>
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
   <script type="text/javascript" src="include/jquery-latest.js"></script> 
<script type="text/javascript" src="include/jquery.tablesorter.js"></script> 
<script type="text/javascript">
$(document).ready(function() 
    { 
        $("#cs").tablesorter(); 
    } 
); 
</script>
</head>
<body>
<div id="wrapper">
	<?php require_once("contest-header.php");?>
<div id=main>
<center><h3>Contest Statistics</h3>
<table id=cs width=90%>
<thead>
<tr align=center class=toprow><th><th>AC<th>PE<th>WA<th>TLE<th>MLE<th>OLE<th>RE<th>CE<th>Total<th><th>C<th>C++<th>Pascal<th>Java<th>Ruby<th>Bash<th>Python<th>PHP<th>Perl<th>C#<th>Obj-c<th>FreeBasic</tr>
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
	for ($j=0;$j<21;$j++) {
		if(!isset($R[$i][$j])) $R[$i][$j]="";
		echo "<td>".$R[$i][$j];
	}
	echo "</tr>";
}
echo "<tr align=center class=evenrow><td>Total";	
for ($j=0;$j<15;$j++) {
	if(!isset($R[$i][$j])) $R[$i][$j]="";
	echo "<td>".$R[$i][$j];
}
echo "</tr>";
?>
  </tbody>
<table></center>;

<div id=foot>
	<?php require_once("oj-footer.php");?>

</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
</body>
</html>
