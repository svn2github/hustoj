<?require_once("admin-header.php");?>
<title>Admin Index</title>

<hr>
<ol>

	<li>
		<a href="../status.php" target="main"><b>SeeOJ</b></a>

<?
if (isset($_SESSION['administrator'])){
	?>
	<li>
		<a href="news_add_page.php" target="main"><b>AddNews</b></a>
	<li>
		<a href="news_list.php" target="main"><b>NewsList</b></a>
	<li>
		<a href="problem_add_page.php" target="main"><b>NewProblem</b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
	<li>
		<a href="problem_list.php" target="main"><b>ProblemList</b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<a href="contest_add.php" target="main"><b>NewContest</b></a>
<?
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<a href="contest_list.php" target="main"><b>ContestList</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?>
<li>
	<a href="setmsg.php" target="main"><b>SetMessage</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="changepass.php" target="main"><b>ChangePassWD</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="rejudge.php" target="main"><b>Rejudge</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="privilege_add.php" target="main"><b>AddPrivilege</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="privilege_list.php" target="main"><b>PrivilegeList</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="source_give.php" target="main"><b>GiveSource</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="problem_export.php" target="main"><b>ExportProblem</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="problem_import.php" target="main"><b>ImportProblem</b></a>
<?
}
if (isset($_SESSION['administrator'])){
?><li>
	<a href="update_db.php" target="main"><b>Update DataBase</b></a>
<?
}
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<a href="../online.php" target="main"><b>Online</b></a>
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
<?
}
?>
