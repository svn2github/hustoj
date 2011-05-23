<?
require_once("oj-header.php");
require_once("./include/db_info.inc.php");
?>
<script src="include/sortTable.js"></script>
<?
$sql="SELECT max(`problem_id`) as upid FROM `problem`";
$page_cnt=100;
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

if (isset($_SESSION['administrator'])){
	
	$sql="SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` WHERE ";
	
}
else{
	$sql="SELECT `problem_id`,`title`,`source`,`submit`,`accepted` FROM `problem` ".
	"WHERE `defunct`='N' AND `problem_id` NOT IN(
		SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN (
			SELECT `contest_id` FROM `contest` WHERE 
			(`end_time`>NOW() or private=1)and `defunct`='N'
			
		)
	) AND";

}
if(isset($_GET['search'])){
	$search=mysql_real_escape_string($_GET['search']);
    $sql.=" ( title like '%$search%' or source like '%$search%')";
    
}else{
	$sql.="  `problem_id`>='".strval($pstart)."' AND `problem_id`<'".strval($pend)."' ";
}
$sql.=" ORDER BY `problem_id`";
?>
<title>Problem Set</title>

<?
$result=mysql_query($sql) or die(mysql_error());
echo "<h3 align='center'>";
for ($i=1;$i<=$cnt+1;$i++){
	if ($i>1) echo '&nbsp;';
	if ($i==$page) echo "<span class=red>$i</span>";
	else echo "<a href='problemset.php?page=".$i."'>".$i."</a>";
}
echo "</h3>";
echo "<center><table id='problemset' width='90%'>";
echo "<thead><tr align='center' class='evenrow'><td width='5'></td>";
echo "<td width='10%' colspan='1'><form action=problem.php>Problem ID<input type='text' name='id' size=5><input type='submit' value='GO' ></form></td>";
echo "<td width='90%' colspan='4'><form>$MSG_SEARCH<input type='text' name='search'><input type='submit' value='$MSG_SEARCH' ></form></td>";
echo "</tr><tr align=center class='toprow'>";
echo "<td width='5'><td style=\"cursor:hand\" onclick=\"sortTable('problemset', 1, 'int');\" width=10%><A>$MSG_PROBLEM_ID</A>";
echo "<td width='60%'>$MSG_TITLE</td><td width='10%'>$MSG_SOURCE</td>";
echo "<td style=\"cursor:hand\" onclick=\"sortTable('problemset', 4, 'int');\" width='5%'><A>$MSG_AC</A></td>";
echo "<td style=\"cursor:hand\" onclick=\"sortTable('problemset', 5, 'int');\" width='5%'><A>$MSG_SUBMIT</A></td></tr>";
echo "</thead><tbody>";
$cnt=0;
while ($row=mysql_fetch_object($result)){
	if ($cnt) echo "<tr class='oddrow'>";
	else echo "<tr class='evenrow'>";
	echo "<td>";
	if (isset($sub_arr[$row->problem_id])){
		if (isset($acc_arr[$row->problem_id])) echo "<span class=yes>Y</span>";
		else echo "<span class=no>N</span>";
	}
	echo "</td>";
	echo "<td align='center'>".$row->problem_id."</td>";
	echo "<td align='left'><a href='problem.php?id=".$row->problem_id."'>".$row->title."</a></td>";
	echo "<td align='center'>".mb_substr($row->source,0,8)."</td>";
	echo "<td align='center'><a href='status.php?problem_id=".$row->problem_id."&jresult=4'>"
		.$row->accepted."</a></td><td align='center'><a href='status.php?problem_id=".$row->problem_id."'>".$row->submit."</a></td>";
	echo "</tr>";
	$cnt=1-$cnt;
}
mysql_free_result($result);
echo "</tbody>";

echo "</table></center>";
?>
<?require_once("oj-footer.php")?>
