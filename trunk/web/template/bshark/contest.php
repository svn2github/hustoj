<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $view_title;?> - <?php echo $MSG_CONTEST;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4>C<?php echo $view_cid;?>: <?php echo $view_title;?> <span class="badge badge-outline-<?php
if ($now>$end_time)
echo "success";
else if ($now<$start_time)
echo "success";
else
echo "danger";
?>"><?php
if ($now>$end_time)
echo $MSG_Ended;
else if ($now<$start_time)
echo "未开始";
else
echo $MSG_Running;
?></span>
<span class="badge badge-outline-<?php
if ($view_private=='0')
echo "info";
else
echo "danger";
?>"><?php
if ($view_private=='0')
echo $MSG_Public;
else
echo $MSG_Private;
?></span></h4>
    <h5><?php echo $MSG_CONTEST;?><?php echo $MSG_TIME;?></h5>
    <span class="badge badge-outline-dark"><?php echo $view_start_time;?></span>~<span class="badge badge-outline-dark"><?php echo $view_end_time;?></span> 现在:<span class="badge badge-outline-dark" id="nowdate"></span>
    <br>
    <h5><?php echo $MSG_CONTEST.$MSG_Description;?></h5>
    <blockquote>
        <?php echo $view_description?>
    </blockquote>
    <hr/>
    <ul class="pagination">
    <li class="page-item"><a class="page-link" href='contest.php?cid=<?php echo $view_cid?>'><?php echo $MSG_CONTEST;?>C<?php echo $cid;?></a></li>
    <li class="page-item"><a class="page-link" href='status.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STATUS;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank-oi.php?cid=<?php echo $view_cid?>'>OI-<?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='conteststatistics.php?cid=<?php echo $view_cid?>'><?php echo $MSG_STATISTICS;?></a></li>
    </ul>
    <?php if (time()>$start_time) { ?>
    <table id='problemset' class='table table-hover'>
<thead>
<tr align=center class='toprow'>
<td><?php echo $MSG_STATUS;?>
<td style="cursor:hand" onclick="sortTable('problemset', 1, 'int');" ><?php echo $MSG_PROBLEM_ID?>
<td><?php echo $MSG_TITLE?></td>
<td><?php echo $MSG_SOURCE?></td>
<td style="cursor:hand" onclick="sortTable('problemset', 4, 'int');"><?php echo $MSG_AC?></td>
<td style="cursor:hand" onclick="sortTable('problemset', 5, 'int');"><?php echo $MSG_SUBMIT?></td>
</tr>
</thead>
<tbody>
<?php
$cnt=0;
foreach($view_problemset as $row){
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
    <?php } ?>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
<script src="include/sortTable.js"></script>
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
