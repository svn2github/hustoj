<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='include/hoj.css' type='text/css'>
</head>
<?
$cid=intval($_GET['cid']);
$pid=intval($_GET['pid']);
?>
<table width=100% class=toprow><tr align=center>
	<td width=15%><a class=u href='./'>Home Page</a>
	<td width=15%><a class=u href='./bbs.php'>Web Board</a>
	<td width=15%><a class=u href='./contest.php?cid=<?=$cid?>'>Problems</a>
	<td width=15%><a class=u href='./contestrank.php?cid=<?=$cid?>'>Standing</a>
	<td width=15%><a class=u href='./status.php?cid=<?=$cid?>'>Status</a>
	<td width=15%><a class=u href='./conteststatistics.php?cid=<?=$cid?>'>Statistics</a>
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
require_once("./include/db_info.inc.php");
$contest_ok=true;
$str_private="SELECT count(*) FROM `contest` WHERE `contest_id`='$cid' && `private`='1'";
$result=mysql_query($str_private);
$row=mysql_fetch_row($result);
mysql_free_result($result);
if ($row[0]=='1' && !isset($_SESSION['c'.$cid])) $contest_ok=false;
if (isset($_SESSION['administrator'])) $contest_ok=true;
?>
