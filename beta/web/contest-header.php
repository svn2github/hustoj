<?php  
    require_once('./include/cache_start.php');

	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='./include/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
</head>
<?php if(isset($_GET['cid']))
	$cid=intval($_GET['cid']);
if (isset($_GET['pid']))
	$pid=intval($_GET['pid']);
?>
<table width=100% class=toprow><tr align=center>
	<td width=15%><a class=hd href='./'><?php echo $MSG_HOME?></a>
	<td width=15%><a class=hd href='./bbs.php?cid=<?php echo $cid?>'><?php echo $MSG_BBS?></a>
	<td width=15%><a class=hd href='./contest.php?cid=<?php echo $cid?>'><?php echo $MSG_PROBLEMS?></a>
	<td width=15%><a class=hd href='./contestrank.php?cid=<?php echo $cid?>'><?php echo $MSG_STANDING?></a>
	<td width=15%><a class=hd href='./status.php?cid=<?php echo $cid?>'><?php echo $MSG_STATUS?></a>
	<td width=15%><a class=hd href='./conteststatistics.php?cid=<?php echo $cid?>'><?php echo $MSG_STATISTICS?></a>
</tr></table>

<div id=broadcast>
<?php

	echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>";
	require('./admin/msg.txt');
	echo "</marquee>";

?>
</div><!--end broadcast-->
