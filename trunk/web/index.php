<?
	require_once("oj-header.php");
	require_once("./include/db_info.inc.php");
	echo "<title>Welcome To Online Judge</title>";
	$sql=	"SELECT * "
			."FROM `news` "
			."WHERE `defunct`!='Y'"
			."ORDER BY `importance` ASC,`time` DESC "
			."LIMIT 5";
	$result=mysql_query($sql);//mysql_escape_string($sql));
	if (!$result){
		echo "<h3>No News Now!</h3>";
		echo mysql_error();
	}else{
		echo "<table width=96%>";
		
		while ($row=mysql_fetch_object($result)){
			echo "<tr><td><td><big><b>".$row->title."</b></big>-<small>[".$row->user_id."]</small></tr>";
			echo "<tr><td><td>".$row->content."</tr>";
		}
		mysql_free_result($result);
		echo "<tr><td width=20%><td>This <a href=http://cm.baylor.edu/welcome.icpc>ACM/ICPC</a> OnlineJudge is a GPL product from <a href=http://code.google.com/p/hustoj>hustoj</a></tr>";
		echo "</table>";
	}
?>
<?php if(function_exists('apc_cache_info')): ?>
<?php $_apc_cache_info = apc_cache_info(); ?>
<div style="text-align:center">
<div style="margin: auto; width:400px; text-align:left">
<h4>Alternative PHP Cache:<strong>ACTIVE</strong></h4>
<strong>Performace Data<strong>
<ul id="apc">
	<li><span>Hits: </span><?=$_apc_cache_info['num_hits']?></li>
	<li><span>Misses: </span><?=$_apc_cache_info['num_misses']?></li>
	<li><span>Entries: </span><?=$_apc_cache_info['num_entries']?></li>
	<li><span>Inserts: </span><?=$_apc_cache_info['num_inserts']?></li>
	<li><span>Cached Files: </span><?=$_apc_cache_info['mem_size']/1024?>KB</li>
</ul>
</div>
</div>
<?php endif;?>

<?php require('oj-footer.php');?>
