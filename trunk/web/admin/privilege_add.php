<?php require_once("admin-header.php");?>
<?php if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	$user_id=$_POST['user_id'];
	$rightstr =$_POST['rightstr'];
	if(isset($_POST['contest'])) $rightstr="c$rightstr";
	if(isset($_POST['psv'])) $rightstr="s$rightstr";
	$sql="insert into `privilege` values(?,?,'N')";
	$rows=pdo_query($sql,$user_id,$rightstr);
	echo "$user_id $rightstr added!";
	
}
?>
<div class="container">
<form method=post>
<?php require("../include/set_post_key.php");?>
	<b>Add privilege for User:</b><br />
	User:<input type=text size=10 name="user_id"><br />
	Privilege:
	<select name="rightstr">
<?php
$rightarray=array("administrator","problem_editor","source_browser","contest_creator","http_judge","password_setter","printer","balloon" );
while(list($key, $val)=each($rightarray)) {
	if (isset($rightstr) && ($rightstr == $val)) {
		echo '<option value="'.$val.'" selected>'.$val.'</option>';
	} else {
		echo '<option value="'.$val.'">'.$val.'</option>';
	}
}
?></select><br />
	<input type='hidden' name='do' value='do'>
	<input type=submit value='Add'>
	<?php echo $MSG_HELP_ADD_PRIVILEGE; ?>
</form>
<form method=post>
	<b>Add contest for User:</b><br />
	User:<input type=text size=10 name="user_id"><br />
	Contest:<input type=text size=10 name="rightstr">1000 for Contest1000<br />
	<input type='hidden' name='do' value='do'>
	<input type='hidden' name='contest' value='do'>
	<input type=submit value='Add'>
	<input type=hidden name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey']?>">
</form>
<form method=post>
	<b>Add Problem Solution View for User:</b><br />
	User:<input type=text size=10 name="user_id"><br />
	Problem:<input type=text size=10 name="rightstr">1000 for Problem 1000<br />
	<input type='hidden' name='do' value='do'>
	<input type='hidden' name='psv' value='do'>
	<input type=submit value='Add'>
	<input type=hidden name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey']?>">
</form>
</div>
