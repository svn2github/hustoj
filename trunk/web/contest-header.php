<?require_once("./include/db_info.inc.php");

	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
	}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='include/hoj.css' type='text/css'>
</head>
<?
$cid=intval($_GET['cid']);
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
<br>
<?
$fp=fopen("admin/msg.txt","r");
$msg="";
while (!feof($fp)){
	$strtmp=fgets($fp);
	$msg=$msg.$strtmp;
}
if (strlen($msg)>5){
	echo "<marquee scrollamount=3 behavior=ALTERNATE scrolldelay=150>";
	echo "<font color=red>";
	echo $msg;
	echo "</font>";
	echo "</marquee>";
}

$contest_ok=true;
$str_private="SELECT count(*) FROM `contest` WHERE `contest_id`='$cid' && `private`='1'";
$result=mysql_query($str_private);
$row=mysql_fetch_row($result);
mysql_free_result($result);
if ($row[0]=='1' && !isset($_SESSION['c'.$cid])) $contest_ok=false;
if (isset($_SESSION['administrator'])) $contest_ok=true;
?>
