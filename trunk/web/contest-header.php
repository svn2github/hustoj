<?require_once("./include/db_info.inc.php");

	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='./include/hoj.css' type='text/css'>
</head>
<?
if(isset($_GET['cid']))
	$cid=intval($_GET['cid']);
if (isset($_GET['pid']))
	$pid=intval($_GET['pid']);
?>
<table width=100% class=toprow><tr align=center>
	<td width=15%><a class=hd href='./'><?=$MSG_HOME?></a>
	<td width=15%><a class=hd href='./bbs.php'><?=$MSG_BBS?></a>
	<td width=15%><a class=hd href='./contest.php?cid=<?=$cid?>'><?=$MSG_PROBLEMS?></a>
	<td width=15%><a class=hd href='./contestrank.php?cid=<?=$cid?>'><?=$MSG_STANDING?></a>
	<td width=15%><a class=hd href='./status.php?cid=<?=$cid?>'><?=$MSG_STATUS?></a>
	<td width=15%><a class=hd href='./conteststatistics.php?cid=<?=$cid?>'><?=$MSG_STATISTICS?></a>
</tr></table>

<div id=broadcast>
<?php

	echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>";
	require('./admin/msg.txt');
	echo "</marquee>";

?>
</div><!--end broadcast-->
<?php
$contest_ok=true;
$str_private="SELECT count(*) FROM `contest` WHERE `contest_id`='$cid' && `private`='1'";
$result=mysql_query($str_private);
$row=mysql_fetch_row($result);
mysql_free_result($result);
if ($row[0]=='1' && !isset($_SESSION['c'.$cid])) $contest_ok=false;
if (isset($_SESSION['administrator'])) $contest_ok=true;
?>
<div id=main>
