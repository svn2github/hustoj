<?
require("admin-header.php");
echo "<title>Problem List</title>";
echo "<center><h2>Problem List</h2></center>";
$sql="select `problem_id`,`title`,`in_date`,`defunct` FROM `problem` order by `problem_id` desc";
$result=mysql_query($sql) or die(mysql_error());
echo "<center><table width=90% border=1>";
echo "<tr><td>Problem ID<td>Title<td>Date<td>Defunct<td>Edit</tr>";
for (;$row=mysql_fetch_object($result);){
	echo "<tr>";
	echo "<td>".$row->problem_id;
	echo "<td><a href='../problem.php?id=$row->problem_id'>".$row->title."</a>";
	echo "<td>".$row->in_date;
	echo "<td><a href=change.php?id=$row->problem_id>".($row->defunct=="N"?"Delete":"Resume")."</a>";
	echo "<td><a href=edit.php?id=$row->problem_id>Edit</a>";
	echo "</tr>";
}
echo "</table></center>";
require("../oj-footer.php");
?>
