<?php
$cache_time=30;
$OJ_CACHE_SHARE=false;
	$debug = true;
	require_once('./oj-header.php');
	require_once('./include/db_info.inc.php');
	require_once('./include/iplocation.php');
	$users = $on->getAll();
	$ip = new IpLocation();
?>
<h3>current online user: <?php echo $on->get_num()?></h3>
<table style="margin:auto;width:98%">
<thead>
<tr><th style="width: 50px">ip</th><th>uri</th><th>refer</th><th style="width:100px">stay time</th><th>user agent</th></tr>
</thead>
<tbody>
<?php foreach($users as $u):
 if(is_object($u)){
 ?>
<tr><td class="ip">
<?php $l = $ip->getlocation($u->ip);
   
	echo $u->ip.'<br />';
	if(strlen(trim($l['area']))==0)
		echo $l['country'];
	else
		echo $l['area'].'@'.$l['country'];
	?></td><td><?php echo $u->uri?></td><td><?php echo $u->refer?></td>
<td class="time"><?php echo sprintf("%dmin %dsec",($u->lastmove-$u->firsttime)/60,($u->lastmove-$u->firsttime) % 60)?></td><td><?php echo $u->ua?></td></tr>
<?php 
}
endforeach;?>
</tbody>
</table>


<?php if (isset($_SESSION['administrator'])){

echo "<center>";
echo "<td width='100%' colspan='5'><form>IP<input type='text' name='search'><input type='submit' value='$MSG_SEARCH' ></form></td></tr>";
if(isset($_GET['search'])){

    $sql="SELECT * FROM `loginlog`";
    $search=trim(mysql_real_escape_string($_GET['search']));
    if ($search!='')
    	$sql=$sql." WHERE ip like '%$search%' ";
     else
        $sql=$sql." where user_id<>'".$_SESSION['user_id']."' ";
    $sql=$sql."  order by `time` desc LIMIT 0,50";

$result=mysql_query($sql) or die(mysql_error());
echo "<table border=1>";
echo "<tr align=center><td>UserID<td>Password<td>IP<td>Time</tr>";
for (;$row=mysql_fetch_row($result);){
        echo "<tr align=center>";
        echo "<td><a href='userinfo.php?user=".$row[0]."'>".$row[0]."</a>";
        echo "<td>".$row[1];
        echo "<td>".$row[2];
        echo "<td>".$row[3];
        echo "</tr>";
}
echo "</table>";

echo "</center>";
mysql_free_result($result);
}

}
?>


<?php require_once('oj-footer.php')?>
