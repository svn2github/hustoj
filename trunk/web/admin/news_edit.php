<?php require_once ("admin-header.php");

if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div class="container">
<?php require_once("../include/db_info.inc.php");
if (isset($_POST['news_id']))
{
	require_once("../include/check_post_key.php");
$title = $_POST ['title'];
$content = $_POST ['content'];
$user_id=$_SESSION[$OJ_NAME.'_'.'user_id'];
$news_id=intval($_POST['news_id']);
if (get_magic_quotes_gpc ()) {
	$title = stripslashes ( $title);
	$content = stripslashes ( $content );
}


	$sql="UPDATE `news` set `title`=?,`time`=now(),`content`=?,user_id=? WHERE `news_id`=?";
	//echo $sql;
	pdo_query($sql,$title,$content,$user_id,$news_id) ;
	
	
	

	header("location:news_list.php");
	exit();
}else{
	$news_id=intval($_GET['id']);
	$sql="SELECT * FROM `news` WHERE `news_id`=?";
	$result=pdo_query($sql,$news_id);
	if (count($result)!=1){
		echo "No such Contest!";
		exit(0);
	}
	$row=$result[0];
	
	$title=htmlentities($row['title'],ENT_QUOTES,"UTF-8");
	$content=$row['content'];
	
		
}
?>
<?php include("kindeditor.php")?>
<form method=POST action='news_edit.php'>
<p align=center><font size=4 color=#333399>Edit a Contest</font></p>
<input type=hidden name='news_id' value=<?php echo $news_id?>>
<p align=left>Title:<input type=text name=title size=71 value='<?php echo $title?>'></p>

<p align=left>Content:<br>
<textarea class=kindeditor name=content ><?php echo htmlentities($content,ENT_QUOTES,"UTF-8")?></textarea>
</p>
<?php require_once("../include/set_post_key.php");?>
<input type=submit>
</form>
</div>

