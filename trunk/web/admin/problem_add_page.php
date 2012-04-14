<html>
<head>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>New Problem</title>
</head>
<body leftmargin="30" >

<?php require_once("../include/db_info.inc.php");?>
<?php require_once("admin-header.php");
if (!(isset($_SESSION['administrator'])||isset($_SESSION['problem_editor']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php
include_once("../fckeditor/fckeditor.php") ;
?>
<h1 >Add New problem</h1>

<form method=POST action=problem_add.php>
<input type=hidden name=problem_id value="New Problem">
<p align=left>Problem Id:&nbsp;&nbsp;New Problem</p>
<p align=left>Title:<input type=text name=title size=71></p>
<p align=left>Time Limit:<input type=text name=time_limit size=20 value=1>S</p>
<p align=left>Memory Limit:<input type=text name=memory_limit size=20 value=128>MByte</p>
<p align=left>Description:<br><!--<textarea rows=13 name=description cols=80></textarea>-->

<?php
$description = new FCKeditor('description') ;
$description->BasePath = '../fckeditor/' ;
$description->Height = 250 ;
$description->Width=800;

$description->Value = '<p></p>' ;
$description->Create() ;
?>
</p>

<p align=left>Input:<br><!--<textarea rows=13 name=input cols=80></textarea>-->

<?php
$input = new FCKeditor('input') ;
$input->BasePath = '../fckeditor/' ;
$input->Height = 250 ;
$input->Width=800;

$input->Value = '<p></p>' ;
$input->Create() ;
?>
</p>

</p>
<p align=left>Output:<br><!--<textarea rows=13 name=output cols=80></textarea>-->


<?php
$output = new FCKeditor('output') ;
$output->BasePath = '../fckeditor/' ;
$output->Height = 250 ;
$output->Width=800;

$output->Value = '<p></p>' ;
$output->Create() ;
?>

</p>
<p align=left>Sample Input:<br><textarea rows=13 name=sample_input cols=80></textarea></p>
<p align=left>Sample Output:<br><textarea rows=13 name=sample_output cols=80></textarea></p>
<p align=left>Test Input:<br><textarea rows=13 name=test_input cols=80></textarea></p>
<p align=left>Test Output:<br><textarea rows=13 name=test_output cols=80></textarea></p>
<p align=left>Hint:<br>
<?php
$output = new FCKeditor('hint') ;
$output->BasePath = '../fckeditor/' ;
$output->Height = 250 ;
$output->Width=800;

$output->Value = '<p></p>' ;
$output->Create() ;
?>
</p>
<p>SpecialJudge: N<input type=radio name=spj value='0' checked>Y<input type=radio name=spj value='1'></p>
<p align=left>Source:<br><textarea name=source rows=1 cols=70></textarea></p>
<p align=left>contest:
	<select  name=contest_id>
<?php $sql="SELECT `contest_id`,`title` FROM `contest` WHERE `start_time`>NOW() order by `contest_id`";
$result=mysql_query($sql);
echo "<option value=''>none</option>";
if (mysql_num_rows($result)==0){
}else{
	for (;$row=mysql_fetch_object($result);)
		echo "<option value='$row->contest_id'>$row->contest_id $row->title</option>";
}
?>
	</select>
</p>
<div align=center>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value=Submit name=submit>
</div></form>
<p>
<?php require_once("../oj-footer.php");?>
</body></html>

