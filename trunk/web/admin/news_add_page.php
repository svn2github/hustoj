<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>New Problem</title>
</head>
<body leftmargin="30" >
<div class="container">

<?php require_once("../include/db_info.inc.php");?>
<?php require_once("admin-header.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php
include_once("kindeditor.php") ;
?>
<form method=POST action=news_add.php>

<p align=left><?php echo $MSG_TITLE?>:<input type=text name=title size=71></p>

<textarea class=kindeditor name=content ></textarea>
</p>
<input type=submit value=Submit name=submit>
<?php require_once("../include/set_post_key.php");?>
</div></form>
</div>
</body></html>

