<?
require_once("oj-header.php");
require_once("./include/db_info.inc.php");
?>
<?
$sql="SELECT max(`problem_id`) as upid FROM `problem`";
$page_cnt=50;
$result=mysql_query($sql);
echo mysql_error();
$row=mysql_fetch_object($result);
$cnt=intval($row->upid)-1000;
$cnt=$cnt/$page_cnt;

if (isset($_GET['page'])){
	$page=intval($_GET['page']);
}else $page="1";
$pstart=1000+$page_cnt*intval($page)-$page_cnt;
$pend=$pstart+$page_cnt;

$sub_arr=Array();
// submit
if (isset($_SESSION['user_id'])){
$sql="SELECT `problem_id` FROM `solution` WHERE `user_id`='".$_SESSION['user_id']."'".
	" AND `problem_id`>='$pstart'".
	" AND `problem_id`<'$pend'".
	" group by `problem_id`";
$result=@mysql_query($sql) or die(mysql_error());
while ($row=mysql_fetch_array($result))
	$sub_arr[$row[0]]=true;
}

$acc_arr=Array();
// ac
if (isset($_SESSION['user_id'])){
$sql="SELECT `problem_id` FROM `solution` WHERE `user_id`='".$_SESSION['user_id']."'".
	" AND `problem_id`>='$pstart'".
	" AND `problem_id`<'$pend'".
	" AND `result`=4".
	" group by `problem_id`";
$result=@mysql_query($sql) or die(mysql_error());
while ($row=mysql_fetch_array($result))
	$acc_arr[$row[0]]=true;
}

if (!isset($_SESSION['administrator'])){
	$sql="SELECT `problem_id`,`title`,`submit`,`accepted` FROM `problem` ".
	"WHERE `defunct`='N' AND `problem_id` NOT IN(
		SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN (
			SELECT `contest_id` FROM `contest` WHERE `end_time`>NOW() or private=1
		)
	)";
	$sql=$sql." AND `problem_id`>='".strval($pstart)."' AND `problem_id`<'".strval($pend)."'  or problem_id=1000 ";
}
else{
	$sql="SELECT `problem_id`,`title`,`submit`,`accepted` FROM `problem` ";
	$sql=$sql."WHERE `problem_id`>='".strval($pstart)."' AND `problem_id`<'".strval($pend)."' ";
}

$sql=$sql."ORDER BY `problem_id`";
?>
<title>Problem Set</title>
<style>
td{font-size:12}
</style>
<?
$result=mysql_query($sql) or die(mysql_error());
echo "<h3 align=center>";
for ($i=1;$i<=$cnt+1;$i++){
	if ($i>1) echo '&nbsp;';
	if ($i==$page) echo "<font color=red>$i</font>";
	else echo "<a href='problemset.php?page=".$i."'>".$i."</a>";
}
echo "</h3>";
echo "<center><table width=90%>";
echo "<tr align=center class='toprow'><td width=5><td width=10%>Problem ID<td width=70%>Title<td width=20%>Ratio(AC/Submit)</tr>";
$cnt=0;
while ($row=mysql_fetch_object($result)){
	if ($cnt) echo "<tr class='oddrow'>";
	else echo "<tr class='evenrow'>";
	echo "<td>";
	if ($sub_arr[$row->problem_id]){
		if ($acc_arr[$row->problem_id]) echo "<font color=green>Y</font>";
		else echo "<font color=red>N</font>";
	}
	echo "<td align=center>".$row->problem_id;
	echo "<td align=left><a href='problem.php?id=".$row->problem_id."'>".$row->title."</a>";
	echo "<td align=center><a href='status.php?problem_id=".$row->problem_id."&jresult=4'>"
		.$row->accepted."</a>/<a href='status.php?problem_id=".$row->problem_id."'>".$row->submit."</a>";
	echo "</tr>";
	$cnt=1-$cnt;
}
mysql_free_result($result);
echo "</center></table>";
?>
<?require_once("oj-footer.php")?>
