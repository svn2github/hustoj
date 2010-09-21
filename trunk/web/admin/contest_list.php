<?
require("admin-header.php");
echo "<title>Problem List</title>";
echo "<center><h2>Contest List</h2></center>";
$sql="select `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` order by `contest_id` desc";
$result=mysql_query($sql) or die(mysql_error());
echo "<center><table width=90% border=1>";
echo "<tr><td>ContestID<td>Title<td>StartTime<td>EndTime<td>Private<td>Delete<td>Edit<td>Copy<td>Export</tr>";
for (;$row=mysql_fetch_object($result);){
	echo "<tr>";
	echo "<td>".$row->contest_id;
	echo "<td><a href='../contest.php?cid=$row->contest_id'>".$row->title."</a>";
	echo "<td>".$row->start_time;
	echo "<td>".$row->end_time;
	echo "<td><a href=contest_pr_change.php?cid=$row->contest_id>".($row->private=="0"?"Public->Private":"Private->Public")."</a>";
	echo "<td><a href=contest_df_change.php?cid=$row->contest_id>".($row->defunct=="N"?"Delete":"Resume")."</a>";
	echo "<td><a href=contest_edit.php?cid=$row->contest_id>Edit</a>";
	echo "<td><a href=contest_add.php?cid=$row->contest_id>Copy</a>";
	echo "<td><a href=problem_export_xml.php?cid=$row->contest_id>Export</a>";
	echo "</tr>";
}
echo "</table></center>";
require("../oj-footer.php");
?>
