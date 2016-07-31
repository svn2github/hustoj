<?php require_once("admin-header.php");

	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
	

?>
<html>
<head>
<title><?php echo $MSG_ADMIN?></title>
</head>

<body>
<hr>
<h4>
<ol>
	<li>
		<a class='btn btn-primary' href="watch.php" target="main"><b><?php echo $MSG_SEEOJ?></b></a>
<?php if (isset($_SESSION['administrator'])){
	?>
	<li>
		<a class='btn btn-primary' href="news_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_NEWS?></b></a>
	<li>
		<a class='btn btn-primary' href="news_list.php" target="main"><b><?php echo $MSG_NEWS.$MSG_LIST?></b></a>
		
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<a class='btn btn-primary' href="problem_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_PROBLEM?></b></a>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<a class='btn btn-primary' href="problem_list.php" target="main"><b><?php echo $MSG_PROBLEM.$MSG_LIST?></b></a>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<a class='btn btn-primary' href="contest_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_CONTEST?></b></a>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<a class='btn btn-primary' href="contest_list.php" target="main"><b><?php echo $MSG_CONTEST.$MSG_LIST?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?>
<li>
	<a class='btn btn-primary' href="team_generate.php" target="main"><b><?php echo $MSG_TEAMGENERATOR?></b></a>
<li>
	<a class='btn btn-primary' href="setmsg.php" target="main"><b><?php echo $MSG_SETMESSAGE?></b></a>
<?php }
if (isset($_SESSION['administrator'])||isset( $_SESSION['password_setter'] )){
?><li>
	<a class='btn btn-primary' href="changepass.php" target="main"><b><?php echo $MSG_SETPASSWORD?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="rejudge.php" target="main"><b><?php echo $MSG_REJUDGE?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="privilege_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_PRIVILEGE?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="privilege_list.php" target="main"><b><?php echo $MSG_PRIVILEGE.$MSG_LIST?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="source_give.php" target="main"><b><?php echo $MSG_GIVESOURCE?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="problem_export.php" target="main"><b><?php echo $MSG_EXPORT.$MSG_PROBLEM?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="problem_import.php" target="main"><b><?php echo $MSG_IMPORT.$MSG_PROBLEM?></b></a>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="update_db.php" target="main"><b><?php echo $MSG_UPDATE_DATABASE?></b></a>
<?php }
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<a class='btn btn-primary' href="../online.php" target="main"><b><?php echo $MSG_ONLINE?></b></a>
<?php }
?>

<li>
	<a class='btn btn-primary' href="https://github.com/zhblue/hustoj/" target="_blank"><b>HUSTOJ</b></a>
<li>
	<a class='btn btn-primary' href="https://github.com/zhblue/freeproblemset/" target="_blank"><b>FreeProblemSet</b></a>
<li>
	<a class='btn btn-primary' href="http://codeup.cn" target="_blank"><b>CodeUP.cn</b></a>
<li>
	<a class='btn btn-primary' href="http://codeup.cn" target="_blank">手机QQ加官方群23361372</a>
	


</ol>
<?php if (isset($_SESSION['administrator'])&&!$OJ_SAE){
?>
	<a href="problem_copy.php" target="main" title="Create your own data"><font color="eeeeee">CopyProblem</font></a> <br>
	<a href="problem_changeid.php" target="main" title="Danger,Use it on your own risk"><font color="eeeeee">ReOrderProblem</font></a>
   
<?php }
?>
<h4>
</body>
</html>
