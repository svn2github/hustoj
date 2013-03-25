<?php require_once("admin-header.php");

	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
	

?>

<ul class="nav">




<?php if (isset($_SESSION['administrator'])){
	?>
	<form action="index.php" method="post">
	<li>
		<button class='menu-btn'  name="news_add"><b><?php echo $MSG_ADD.$MSG_NEWS?></b></button>
	<li>
		<button class='menu-btn'  name="news_list"><b><?php echo $MSG_NEWS.$MSG_LIST?></b></button>
		
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<button class='menu-btn' name="problem_add_page"><b><?php echo $MSG_ADD.$MSG_PROBLEM?></b></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<button class='menu-btn'  name="problem_list"><b><?php echo $MSG_PROBLEM.$MSG_LIST?></b></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<button class='menu-btn' name="contest_add"><b><?php echo $MSG_ADD.$MSG_CONTEST?></b></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<button class='menu-btn'  name="contest_list"><b><?php echo $MSG_CONTEST.$MSG_LIST?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?>
<li>
	<button class='menu-btn'  name="team_generate"><b><?php echo $MSG_TEAMGENERATOR?></b></button>
<li>
	<button   class="menu-btn" name="setmsg"><b><?php echo $MSG_SETMESSAGE?></b></button>
<?php }
if (isset($_SESSION['administrator'])||isset( $_SESSION['password_setter'] )){
?><li>
	<button class='menu-btn' name="changepass"><b><?php echo $MSG_SETPASSWORD?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="rejudge"><b><?php echo $MSG_REJUDGE?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn' name="privilege_add"><b><?php echo $MSG_ADD.$MSG_PRIVILEGE?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="privilege_list"><b><?php echo $MSG_PRIVILEGE.$MSG_LIST?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="source_give"><b><?php echo $MSG_GIVESOURCE?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="problem_export"><b><?php echo $MSG_EXPORT.$MSG_PROBLEM?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="problem_import"><b><?php echo $MSG_IMPORT.$MSG_PROBLEM?></b></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='menu-btn'  name="update_db"><b><?php echo $MSG_UPDATE_DATABASE?></b></button>
<?php }
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<button class='menu-btn' require("../online.php") name="online"><b><?php echo $MSG_ONLINE?></b></button>
<?php }
?>

<?php 
//<li><button class='menu-btn' require("http://code.google.com/p/hustoj/") target="_blank"><b>HUSTOJ</b></button>
//<li><button class='menu-btn' require("http://code.google.com/p/freeproblemset/") target="_blank"><b>FreeProblemSet</b></button>
?>

<?php if (isset($_SESSION['administrator'])&&!$OJ_SAE){
?>
	<li><button  name="problem_copy" title="Create your own data" class='menu-btn'><font>CopyProblem</font></button>
	<li><button  name="problem_changeid" title="Danger,Use it on your own risk" class='menu-btn'><font>ReOrderProblem</font></button>
<?php }
?>
</form>
</ul>
