<?php
	require_once("discuss_func.inc.php");
	if(isset($_REQUEST['pid']))
		$pid=intval($_REQUEST['pid']); 
	else
		$pid=0;
	if(isset($_REQUEST['pid']))
		$cid=intval($_REQUEST['cid']);
	else
		$cid=0;
	$prob_exist = problem_exist($pid, $cid);
	if ($cid!='' && $cid!=null && $prob_exist) require_once("contest-header.php");
	else require_once("oj-header.php");
	echo "<title>HUST Online Judge WebBoard</title>";
?>

<center>
<div style="width:90%">
<?php
if ($prob_exist){?>
<div style="text-align:left;font-size:80%">
[ <a href="newpost.php<?
if ($pid!=0 && $cid!=null) echo "?pid=".$pid."&cid=".$cid;
else if ($pid!=0) echo "?pid=".$pid;
else if ($cid!=null) echo "?cid=".$cid;?>
">New Thread</a> ]</div>
<div style="float:left;text-align:left;font-size:80%">
Location : 
<?
if ($cid!=null) echo "<a href=\"discuss.php?cid=".$cid."\">Contest ".$cid."</a>"; else echo "<a href=\"discuss.php\">MainBoard</a>";
if ($pid!=null && $pid!=0) echo " >> <a href=\"discuss.php?pid=".$pid."&cid=".$cid."\">Problem ".$pid."</a>";?>
</div>

<div style="float:right;font-size:80%;color:red;font-weight:bold">
<? if ($pid!=null && $pid!=0 && ($cid=='' || $cid==null)){?>
<a href="problem.php?id=<?echo $pid?>">See the problem</a>
<?}?>
</div>
<?}
$sql = "SELECT `tid`, `title`, `top_level`, `topic`.`status`, `cid`, `pid`, CONVERT(MIN(`reply`.`time`),DATE) `posttime`, MAX(`reply`.`time`) `lastupdate`, `topic`.`author_id`, COUNT(`rid`) `count` FROM `topic`, `reply` WHERE `topic`.`status`!=2 AND `reply`.`status`!=2 AND `tid` = `topic_id`";
if (array_key_exists("cid",$_REQUEST)&&$_REQUEST['cid']!='') $sql.= " AND ( `cid` = '".mysql_escape_string($_REQUEST['cid'])."'";
else $sql.=" AND ( ISNULL(`cid`)";
$sql.=" OR `top_level` = 3 )";
if (array_key_exists("pid",$_REQUEST)&&$_REQUEST['pid']!=''){
  $sql.=" AND ( `pid` = '".mysql_escape_string($_REQUEST['pid'])."' OR `top_level` >= 2 )";
  $level="";
}
else
  $level=" - ( `top_level` = 1 AND `pid` != 0 )";
$sql.=" GROUP BY `topic_id` ORDER BY `top_level`$level DESC, MAX(`reply`.`time`) DESC";
$sql.=" LIMIT 30";
//echo $sql;
$result = mysql_query($sql) or die("Error! ".mysql_error());
$rows_cnt = mysql_num_rows($result);
$cnt=0;
$isadmin = isset($_SESSION['administrator']);
?>
<table style="clear:both; width:100%">
<tr align=center class='toprow'>
	<td width="2%"><? if ($isadmin) echo "<input type=checkbox>"; ?></td>
	<td width="3%"></td>
	<td width="4%">Prob</td>
	<td width="12%">Author</td>
	<td width="46%">Title</td>
	<td width="8%">Post Date</td>
	<td width="16%">Last Reply</td>
	<td width="3%">Re</td>
</tr>
<?
if ($rows_cnt==0) echo("<tr class=\"evenrow\"><td colspan=4></td><td style=\"text-align:center\">No thread here.</td></tr>");

for ($i=0;$i<$rows_cnt;$i++){
	mysql_data_seek($result,$i);
	$row=mysql_fetch_object($result);
	if ($cnt) echo "<tr align=center class='oddrow'>";
	else echo "<tr align=center class='evenrow'>";
	$cnt=1-$cnt;
	if ($isadmin) echo "<td><input type=checkbox></td>"; else echo("<td></td>");
	echo "<td>";
		if ($row->top_level!=0){
			if ($row->top_level!=1||$row->pid==($pid==''?0:$pid))
			echo"<b class=\"Top{$row->top_level}\">Top</b>";
		}
		else if ($row->status==1) echo"<b class=\"Lock\">Lock</b>";
		else if ($row->count>20) echo"<b class=\"Hot\">Hot</b>";
	echo "</td>";
	echo "<td>";
	if ($row->pid!=0) echo"<a href=\"discuss.php?pid={$row->pid}&cid={$row->cid}\">{$row->pid}</a>";
	echo "</td>";
	echo "<td><a href=\"../userinfo.php?user={$row->author_id}\">{$row->author_id}</a></td>";
	echo "<td><a href=\"thread.php?tid={$row->tid}\">".nl2br(htmlspecialchars($row->title))."</a></td>";
	echo "<td>{$row->posttime}</td>";
	echo "<td>{$row->lastupdate}</td>";
	echo "<td>".($row->count-1)."</td>";
	echo "</tr>";
}
mysql_free_result($result);

?>

</table> 
<span style = "font-size:75%; margin:0 10">[<b class="top3">Top</b>] 总置顶</span>
<span style = "font-size:75%; margin:0 10">[<b class="top2">Top</b>] 分区置顶</span>
<span style = "font-size:75%; margin:0 10">[<b class="top1">Top</b>] 题目置顶</span>
<span style = "font-size:75%; margin:0 10">[<b class="hot">Hot</b>] 热帖</span>
<span style = "font-size:75%; margin:0 10">[<b class="lock">Lock</b>] 锁帖</span>
</div>
</center>
<?require_once("../oj-footer.php")?>
