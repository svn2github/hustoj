<?
require_once("admin-header.php");

	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
	

?>
<html>
<head>
<title><?=$MSG_ADMIN?></title>
</head>

<body>
<hr>
<ol>
	<li>
		<a href="../status.php" target="main"><b><?=$MSG_SEEOJ?></b></a>
<?
if (isset($_SESSION['administrator'])){
	?>
	<li>
		<a href="news_add_page.php" target="main"><b><?=$MSG_ADD.$MSG_NEWS?></b></a>
	<li>
		<a href="news_list.php" target="main"><b><?=$MSG_NEWS.$MSG_LIST?></b></a>
	<li>
		<a href="problem_add_page.php" target="main"><b><?=$MSG_ADD.$MSG_PROBLEM?></b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
	<li>
		<a href="problem_list.php" target="main"><b><?=$MSG_PROBLEM.$MSG_LIST?></b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<a href="contest_add.php" target="main"><b><?=$MSG_ADD.$MSG_CONTEST?></b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<a href="contest_list.php" target="main"><b><?=$MSG_CONTEST.$MSG_LIST?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?>
<li>
	<a href="team_generate.php" target="main"><b><?=$MSG_TEAMGENERATOR?></b></a>
<li>
	<a href="setmsg.php" target="main"><b><?=$MSG_SETMESSAGE?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="changepass.php" target="main"><b><?=$MSG_SETPASSWORD?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="rejudge.php" target="main"><b><?=$MSG_REJUDGE?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="privilege_add.php" target="main"><b><?=$MSG_ADD.$MSG_PRIVILEGE?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="privilege_list.php" target="main"><b><?=$MSG_PRIVILEGE.$MSG_LIST?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="source_give.php" target="main"><b><?=$MSG_GIVESOURCE?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="problem_export.php" target="main"><b><?=$MSG_EXPORT.$MSG_PROBLEM?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="problem_import.php" target="main"><b><?=$MSG_IMPORT.$MSG_PROBLEM?></b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="update_db.php" target="main"><b><?=$MSG_UPDATE_DATABASE?></b></a>
<?
}
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<a href="../online.php" target="main"><b><?=$MSG_ONLINE?></b></a>
<?
}
?>

<li>
	<a href="http://code.google.com/p/hustoj/" target="main"><b>HUSTOJ</b></a>
<li>
	<a href="http://code.google.com/p/freeproblemset/" target="main"><b>FreeProblemSet</b></a>

</ol>
<?
if (isset($_SESSION['administrator'])){
?>
	<a href="problem_copy.php" target="main"><font color="eeeeee">CopyProblem</font></a>
	<a href="problem_reorder.php" target="main"><font color="eeeeee">ReOrderProblem</font></a>
<?
}
?>
</body>
</html>
