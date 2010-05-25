<?
	session_start();
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='../include/hoj.css' type='text/css'>
<?

function checkcontest(){
	require_once("../include/db_info.inc.php");
	$sql="SELECT count(*) FROM `contest` WHERE `end_time`>NOW() AND `defunct`='N'";
	$result=mysql_query($sql);
	$row=mysql_fetch_row($result);
	if (intval($row[0])==0) $retmsg="CONTEST";
	else $retmsg=$row[0]."<font color=red>&nbsp;CONTESTs</font>";
	mysql_free_result($result);
	return $retmsg;
}

	require_once('../include/db_info.inc.php');
	require_once('../include/online.php');
	$on = new online();
?>
</head>
<body>
<center>
<h2><font color="red">Welcome To <?=$OJ_NAME?> ACM-ICPC Online Judge</font></h2>
<table width=96%>
	<tr align="center" class='hd' valign="top">
		<th><a href="../faqs.php">F.A.Qs</a></th>
		<th><a href="../discuss.php">BBS</a></th>
		<th><a href="<?=$OJ_HOME?>">HOME</a></th>
		<th><a href="../problemset.php">PROBLEMS</a></th>
		<th><a href="../status.php">STATUS</a></th>
		<th><a href="../ranklist.php">RANKLIST</a></th>
		<th><a href="../contest.php"><?=checkcontest()?></a></th>
		<?
			$sid=$_SESSION['user_id'];
			if (isset($_SESSION['user_id'])){
				print "<th><a href=../modifypage.php><b>U</b></a>&nbsp;&nbsp;<a href='userinfo.php?user=$sid'><font color=red>$sid</font></a></th>";
				print "<th><a href=../logout.php>LOGOUT</a></th>";
			}else{
				print "<th><a href=../loginpage.php>LOGIN</a></th>";
				print "<th><a href=../registerpage.php>REGISTER</a></th>";
			}
			if (isset($_SESSION['administrator'])){
				print "<th><a href=../admin>Admin</a></th>";
			
			}
		?>
	</tr>
</table>
</center>
<?
$fp=fopen("../admin/msg.txt","r");
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
?>
<hr>
<br>
