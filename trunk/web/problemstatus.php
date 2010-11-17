<?
require_once("./include/db_info.inc.php");
if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
require_once("./include/const.inc.php");
require_once("oj-header.php");
$id=strval(intval($_GET['id']));
if (isset($_GET['page']))
	$page=strval(intval($_GET['page']));
else $page=0;

echo "<title>Problem $id Status</title>";
?>
<script type="text/javascript" src="include/wz_jsgraphics.js"></script>
<script type="text/javascript" src="include/pie.js"></script>
<?
echo "<h1>Problem $id Status</h1>";

echo "<center><table><tr><td>";
echo "<table id=statics >";
// total submit
$sql="SELECT count(*) FROM solution WHERE problem_id='$id'";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_array($result);
echo "<tr bgcolor=#D7EBFF><td>Total Submissions<td>".$row[0]."</tr>";
$total=intval($row[0]);
mysql_free_result($result);

// total users
$sql="SELECT count(DISTINCT user_id) FROM solution WHERE problem_id='$id'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
echo "<tr bgcolor=#D7EBFF><td>Users(Submitted)<td>".$row[0]."</tr>";
mysql_free_result($result);

// ac users
$sql="SELECT count(DISTINCT user_id) FROM solution WHERE problem_id='$id' AND result='4'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$acuser=intval($row[0]);
echo "<tr bgcolor=#D7EBFF><td>Users(Solved)<td>".$row[0]."</tr>";
mysql_free_result($result);

//for ($i=4;$i<12;$i++){
	//$i=0;
	$sql="SELECT result,count(1) FROM solution WHERE problem_id='$id' AND result>=4 group by result order by result";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		
		//i++;
		echo "<tr bgcolor=#D7EBFF><td>".$jresult[$row[0]]."<td><a href=status.php?problem_id=$id&jresult=".$row[0]." >".$row[1]."</a></tr>";
	}
	mysql_free_result($result);
	
//}
echo "<tr id=pie bgcolor=white><td colspan=2><div id='PieDiv' style='position:relative;height:150px;width:200px;'></div></tr>";
echo "</table>";
?>
<script language="javascript">
	var y= new Array ();
	var x = new Array ();
	var dt=document.getElementById("statics");
	var data=dt.rows;
	var n;
	for(var i=3;dt.rows[i].id!="pie";i++){
			x.push(dt.rows[i].cells[0].innerHTML);
			n=dt.rows[i].cells[1].firstChild;
			n=n.innerText || n.textContent;
			//alert(n);
			n=parseInt(n);
			y.push(n);
	}
	var mypie=  new Pie("PieDiv");
	mypie.drawPie(y,x);
	//mypie.clearPie();

</script> 

<?
$pagemin=0; $pagemax=intval(($acuser-1)/20);

if ($page<$pagemin) $page=$pagemin;
if ($page>$pagemax) $page=$pagemax;
$start=$page*20;
$sz=20;
if ($start+$sz>$acuser) $sz=$acuser-$start;

$sql=" SELECT solution_id, count(*) att ,user_id, language, min(10000000000000000000+time *100000000000 + memory *100000 + code_length ) score, in_date
FROM solution
WHERE problem_id =$id
AND result =4
GROUP BY user_id
ORDER BY score, in_date
LIMIT  $start, $sz";

$result=mysql_query($sql);

// check whether the problem in a contest

$sql="SELECT count(*) FROM `contest_problem` WHERE `problem_id`=$id AND `contest_id` IN (
	SELECT `contest_id` FROM `contest` WHERE `start_time`<NOW() AND `end_time`>NOW())";
$rrs=mysql_query($sql);

$rrow=mysql_fetch_row($rrs);
if (intval($rrow[0])>0) $flag=false;
else $flag=true;

echo "<td>";
echo "<table>";
echo "<tr class=toprow><td>Rank<td>RunID<td>User<td>Memory<td>Time<td>Language<td>Code Length<td>Submit Time</tr>";
for ($i=$start+1;$row=mysql_fetch_object($result);$i++){
	$sscore=strval($row->score);
	$s_time=intval(substr($sscore,1,8));
	$s_memory=intval(substr($sscore,9,6));
	$s_cl=intval(substr($sscore,15,5));
	if ($i&1) echo "<tr class=oddrow>";
	else echo "<tr class=evenrow>";
	echo "<td>$i";
	echo "<td>$row->solution_id";
	if (intval($row->att)>1) echo "(".$row->att.")";
	echo "<td><a href='userinfo.php?user=".$row->user_id."'>".$row->user_id."</a>";
	echo "<td>";
	if ($flag) echo "$s_memory KB";
	else echo "------";
	echo "<td>";
	if ($flag) echo "$s_time MS";
	else echo "------";
	
	if (!(isset($_SESSION['user_id'])&&strtolower($row->user_id)==strtolower($_SESSION['user_id']) || isset($_SESSION['source_browser']))){
		echo "<td>".$language_name[$row->language];
	}else{
		echo "<td><a target=_blank href=showsource.php?id=".$row->solution_id.">".$language_name[$row->language]."</a>";
	}echo "<td>";
	if ($flag) echo "$s_cl B";
	else echo "------";
	echo "<td>$row->in_date";
	echo "<tr>";
}
echo "</table>";
mysql_free_result($result);
echo "<a href='problemstatus.php?id=$id'>[TOP]</a>";
echo "&nbsp;&nbsp;<a href='status.php?problem_id=$id'>[STATUS]</a>";
if ($page>$pagemin){
	$page--;
	echo "&nbsp;&nbsp;<a href='problemstatus.php?id=$id&page=$page'>[PREV]</a>";
	$page++;
}
if ($page<$pagemax){
	$page++;
	echo "&nbsp;&nbsp;<a href='problemstatus.php?id=$id&page=$page'>[NEXT]</a>";
	$page--;
}

echo "</tr></table></center>";
require_once("oj-footer.php");
?>

