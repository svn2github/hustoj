<?require_once("oj-header.php")?>
<?require_once("./include/db_info.inc.php")?>
<?
// check user
$user=$_GET['user'];
$sql="SELECT `school`,`email`,`nick` FROM `users` WHERE `user_id`='$user'";
$result=mysql_query($sql);
$row_cnt=mysql_num_rows($result);
if ($row_cnt==0){
	echo "No such User!";
	exit(0);
}
echo "<title>User--$user</title>";
$row=mysql_fetch_object($result);
$school=$row->school;
$email=$row->email;
$nick=$row->nick;
mysql_free_result($result);
// count solved
$sql="SELECT count(DISTINCT problem_id) as `ac` FROM `solution` WHERE `user_id`='".$_GET['user']."' AND `result`=4";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_object($result);
$AC=$row->ac;
mysql_free_result($result);
// count submission
$sql="SELECT count(solution_id) as `Submit` FROM `solution` WHERE `user_id`='".$_GET['user']."'";
$result=mysql_query($sql) or die(mysql_error());
$row=mysql_fetch_object($result);
$Submit=$row->Submit;
mysql_free_result($result);
// update solved 
$sql="UPDATE `users` SET `solved`='".strval($AC)."',`submit`='".strval($Submit)."' WHERE `user_id`='".$user."'";
$result=mysql_query($sql);
$sql="SELECT count(*) as `Rank` FROM `users` WHERE `solved`>$AC";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$Rank=intval($row[0])+1;
?>
<center>
<table width=70%>
<caption><?=$user."--".$nick?></caption>
<tr bgcolor=#ccffff><td width=15%>Rank:<td width=25% align=center><?=$Rank?><td width=70% align=center>Solved Problems List</tr>
<tr bgcolor=#ccffff><td>Solved:<td align=center><a href='status.php?user_id=<?=$user?>&jresult=4'><?=$AC?></a>
<td rowspan=4 align=center>
<script language='javascript'>
function p(id){document.write("<a href=problem.php?id="+id+">"+id+" </a>");}
<?
$sql="SELECT DISTINCT `problem_id` FROM `solution` WHERE `user_id`='$user' AND `result`=4 ORDER BY `problem_id` ASC";	
if (!($result=mysql_query($sql))) echo mysql_error();
while ($row=mysql_fetch_array($result))
	echo "p($row[0]);";
mysql_free_result($result);
?>
</script>
</tr>
<tr bgcolor=#ccffff><td>Submmissions:<td align=center><a href='status.php?user_id=<?=$user?>'><?=$Submit?></a></tr>
<tr bgcolor=#ccffff><td>School:<td align=center><?=$school?></tr>
<tr bgcolor=#ccffff><td>Email:<td align=center><?=$email?></tr>
</table>
<?
if (isset($_SESSION['administrator'])){
$sql="SELECT * FROM `loginlog` WHERE `user_id`='$user' order by `time` desc LIMIT 0,10";
$result=mysql_query($sql) or die(mysql_error());
echo "<table border=1>";
echo "<tr align=center><td>UserID<td>Password<td>IP<td>Time</tr>";
for (;$row=mysql_fetch_row($result);){
	echo "<tr align=center>";
	echo "<td>".$row[0];
	echo "<td>".$row[1];
	echo "<td>".$row[2];
	echo "<td>".$row[3];
	echo "</tr>";
}
echo "</table>";
mysql_free_result($result);
}
?>
</center>
<?require_once("oj-footer.php")?>
