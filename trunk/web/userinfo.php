<?require_once("oj-header.php")?>
<?require_once("./include/db_info.inc.php");
if(isset($OJ_LANG))
		require_once("./lang/$OJ_LANG.php");
require_once("./include/const.inc.php");
require_once("./include/my_func.inc.php");
?>

<script type="text/javascript" src="include/wz_jsgraphics.js"></script>
<script type="text/javascript" src="include/pie.js"></script>
<?
// check user
$user=$_GET['user'];
if (!is_valid_user_name($user)){
	echo "No such User!";
	exit(0);
}
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
<table id=statics width=70%>
<caption><?=$user."--".$nick?></caption>
<tr bgcolor=#D7EBFF><td width=15%><?=$MSG_Number?><td width=25% align=center><?=$Rank?><td width=70% align=center>Solved Problems List</tr>
<tr bgcolor=#D7EBFF><td><?=$MSG_SOVLED?><td align=center><a href='status.php?user_id=<?=$user?>&jresult=4'><?=$AC?></a>
<td rowspan=14 align=center>
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
<tr bgcolor=#D7EBFF><td><?=$MSG_SUBMIT?><td align=center><a href='status.php?user_id=<?=$user?>'><?=$Submit?></a></tr>
<?php 
	$sql="SELECT result,count(1) FROM solution WHERE `user_id`='$user'  AND result>=4 group by result order by result";
	$result=mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		
		//i++;
		echo "<tr bgcolor=#D7EBFF><td>".$jresult[$row[0]]."<td align=center><a href=status.php?user_id=$user&jresult=".$row[0]." >".$row[1]."</a></tr>";
	}
	mysql_free_result($result);
	
//}
echo "<tr id=pie bgcolor=#D7EBFF><td>Statistics<td><div id='PieDiv' style='position:relative;height:105px;width:120px;'></div></tr>";

?>
<script language="javascript">
	var y= new Array ();
	var x = new Array ();
	var dt=document.getElementById("statics");
	var data=dt.rows;
	var n;
	for(var i=3;dt.rows[i].id!="pie";i++){
			n=dt.rows[i].cells[0];
			n=n.innerText || n.textContent;
			x.push(n);
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


<tr bgcolor=#D7EBFF><td>School:<td align=center><?=$school?></tr>
<tr bgcolor=#D7EBFF><td>Email:<td align=center><?=$email?></tr>
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
