<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_CONTEST;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
        <div class="col-md-8">
        <div class="card">
  <div class="card-body">
    <h4><?php echo $MSG_CONTEST;?></h4>
    <ul class="pagination">
<li class="page-item"><a class="page-link" href="contest.php?page=1">&lt;&lt;</a></li>
<?php
if(!isset($page)) $page=1;
$page=intval($page);
$section=8;
$start=$page>$section?$page-$section:1;
$end=$page+$section>$view_total_page?$view_total_page:$page+$section;
for ($i=$start;$i<=$end;$i++){
 echo "<li class='".($page==$i?"active ":"")."page-item'>
            <a class='page-link' title='go to page' href='contest.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
}
?>
<li class="page-item"><a class="page-link" href="contest.php?page=<?php echo $view_total_page?>">&gt;&gt;</a></li>
</ul>
    <table class="table table-hover">
    <thead>
<tr class=toprow align=center>
            <td><?php echo $MSG_CONTEST_ID?></td>
            <td><?php echo $MSG_CONTEST_NAME?></td>
            <td><?php echo $MSG_CONTEST_STATUS?></td>
            <td><?php echo $MSG_CONTEST_OPEN?></td>
            <td><?php echo $MSG_CONTEST_CREATOR?></td></tr>
</thead>
<tbody>
<?php
$cnt=0;
foreach($view_contest as $row){
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
    </div>
</div>
</div>
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h4>现在时间</h4>
<span id=nowdate></span>
</div>
</div>
<br>
<div class="card">
<div class="card-body">
<h4>查询</h4>
<form method=post action=contest.php class="form-inline" >
	<input class="form-control" name=keyword type=text >
	<input class="btn btn-outline-dark" type=submit value="查询">
</form>
</div>
</div>
</div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
<script>
var diff=new Date("<?php echo date("Y/m/d H:i:s")?>").getTime()-new Date().getTime();
//alert(diff);
function clock()
{
var x,h,m,s,n,xingqi,y,mon,d;
var x = new Date(new Date().getTime()+diff);
y = x.getYear()+1900;
if (y>3000) y-=1900;
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
    </body>
</html>
