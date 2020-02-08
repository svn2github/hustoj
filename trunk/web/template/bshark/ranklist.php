<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_RANKLIST;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4><?php echo $MSG_RANKLIST;?></h4>
    <form class="form-inline" action="ranklist.php">
<?php echo $MSG_USER?><input class="form-control" name="prefix" value="<?php echo htmlentities(isset($_GET['prefix'])?$_GET['prefix']:"",ENT_QUOTES,"utf-8") ?>" >
<input type=submit class="form-control btn btn-outline-primary" value=Search >
</form>
    <a href=ranklist.php?scope=d>Day</a>
<a href=ranklist.php?scope=w>Week</a>
<a href=ranklist.php?scope=m>Month</a>
<a href=ranklist.php?scope=y>Year</a>
<hr/>
<?php
echo "<ul class=\"pagination\">";
$qs="";
if(isset($_GET['prefix'])){
	$qs.="&prefix=".htmlentities($_GET['prefix'],ENT_QUOTES,"utf-8");
}
if(isset($scope)){
	$qs.="&scope=".htmlentities($scope,ENT_QUOTES,"utf-8");
}
for($i = 0; $i <$view_total ; $i += $page_size) {
	echo "<li class=\"page-item";
	if ($i == $_GET['start']) {
	    echo " active";
	}
	echo "\"><a class=\"page-link\" href='./ranklist.php?start=" . strval ( $i ).$qs. "'>";
	echo strval ( $i + 1 );
	echo "-";
	echo strval ( $i + $page_size );
	echo "</a></li>&nbsp;";
}
echo "</ul>";
?>
    <table class="table table-hover">
    <thead>
<tr class='toprow'>
<td width=7% align=center><b><?php echo $MSG_Number?></b>
<td width=10% align=center><b><?php echo $MSG_USER?></b>
<td width=53% align=center><b><?php echo $MSG_NICK?></b>
<td width=10% align=center><b><?php echo $MSG_AC?></b>
<td width=10% align=center><b><?php echo $MSG_SUBMIT?></b>
<td width=10% align=center><b><?php echo $MSG_RATIO?></b>
</tr>
</thead>
<tbody>
<?php
$cnt=0;
foreach($view_rank as $row){
if ($cnt)
echo "<tr class='oddrow'>";
else
echo "<tr class='evenrow'>";
foreach($row as $table_cell){
echo "<td>";
echo "\t".$table_cell;
echo "</td>";
}
echo "</tr>";
$cnt=1-$cnt;
}
?>
</tbody>
</table>
<?php
echo "<ul class=\"pagination\">";
$qs="";
if(isset($_GET['prefix'])){
	$qs.="&prefix=".htmlentities($_GET['prefix'],ENT_QUOTES,"utf-8");
}
if(isset($scope)){
	$qs.="&scope=".htmlentities($scope,ENT_QUOTES,"utf-8");
}
for($i = 0; $i <$view_total ; $i += $page_size) {
	echo "<li class=\"page-item";
	if ($i == $_GET['start']) {
	    echo " active";
	}
	echo "\"><a class=\"page-link\" href='./ranklist.php?start=" . strval ( $i ).$qs. "'>";
	echo strval ( $i + 1 );
	echo "-";
	echo strval ( $i + $page_size );
	echo "</a></li>&nbsp;";
}
echo "</ul>";
?>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
