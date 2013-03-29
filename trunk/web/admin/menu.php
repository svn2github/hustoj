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
		<button class='btn menu-btn'   name="news_add" ><a class="a-color" href="news_add_page.php"><?php echo $MSG_ADD.$MSG_NEWS?></a></button>
	<li>
		<button class='btn menu-btn'  name="news_list"><a class="a-color" href="news_list.php"><?php echo $MSG_NEWS.$MSG_LIST?></a></button>
		
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<button class='btn menu-btn' name="problem_add_page"><a class="a-color" href="problem_add_page.php"><?php echo $MSG_ADD.$MSG_PROBLEM?></a></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<button class='btn menu-btn'  name="problem_list"><a class="a-color" href="problem_list.php"><?php echo $MSG_PROBLEM.$MSG_LIST?></a></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<button class='btn menu-btn' name="contest_add"><a class="a-color" href="contest_add.php"><?php echo $MSG_ADD.$MSG_CONTEST?></a></button>
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<button class='btn menu-btn'  name="contest_list"><a class="a-color" href="contest_list.php"><?php echo $MSG_CONTEST.$MSG_LIST?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?>
<li>
	<button class='btn menu-btn'  name="team_generate"><a class="a-color" href="team_generate.php"><?php echo $MSG_TEAMGENERATOR?></a></button>
<li>
	<button   class="menu-btn" name="setmsg"><a class="a-color" href="setmsg.php"><?php echo $MSG_SETMESSAGE?></a></button>
<?php }
if (isset($_SESSION['administrator'])||isset( $_SESSION['password_setter'] )){
?><li>
	<button class='btn menu-btn' name="changepass"><a class="a-color" href="changepass.php"><?php echo $MSG_SETPASSWORD?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="rejudge"><a class="a-color" href="rejudge.php"><?php echo $MSG_REJUDGE?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn' name="privilege_add"><a class="a-color" href="privilege_add.php"><?php echo $MSG_ADD.$MSG_PRIVILEGE?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="privilege_list"><a class="a-color" href="privilege_list.php"><?php echo $MSG_PRIVILEGE.$MSG_LIST?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="source_give"><a class="a-color" href="source_give.php"><?php echo $MSG_GIVESOURCE?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="problem_export"><a class="a-color" href="problem_export.php"><?php echo $MSG_EXPORT.$MSG_PROBLEM?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="problem_import"><a class="a-color" href="problem_import.php"><?php echo $MSG_IMPORT.$MSG_PROBLEM?></a></button>
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<button class='btn menu-btn'  name="update_db"><a class="a-color" href="update_db.php"><?php echo $MSG_UPDATE_DATABASE?></a></button>
<?php }
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<button class='btn menu-btn' require("../online.php") name="online"><a class="a-color" href=""><?php echo $MSG_ONLINE?></a></button>
<?php }
?>

<?php 
//<li><button class='btn menu-btn' require("http://code.google.com/p/hustoj/") target="_blank"><a class="a-color" href="">HUSTOJ</a></button>
//<li><button class='btn menu-btn' require("http://code.google.com/p/freeproblemset/") target="_blank"><a class="a-color" href="">FreeProblemSet</a></button>
?>

<?php if (isset($_SESSION['administrator'])&&!$OJ_SAE){
?>
	<li><button  name="problem_copy" title="Create your own data" class='btn menu-btn'><font>CopyProblem</font></button>
	<li><button  name="problem_changeid" title="Danger,Use it on your own risk" class='btn menu-btn'><font>ReOrderProblem</font></button>
<?php }
?>
</form>
</ul>
