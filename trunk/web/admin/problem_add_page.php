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
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php
include_once("kindeditor.php") ;
?>
<form method=POST action=problem_add.php>
<input type=hidden name=problem_id value="New Problem">
<p align=left><?php echo $MSG_TITLE?>:<input class="input input-xxlarge" type=text name=title size=71></p>
<p align=left><?php echo $MSG_Time_Limit?>:<input class="input input-mini" type=text name=time_limit size=20 value=1>S
<?php echo $MSG_Memory_Limit?>:<input class="input input-mini" type=text name=memory_limit size=20 value=128>MByte</p>
<p align=left><?php echo $MSG_Description?>:<br>
<textarea class="kindeditor" rows=13 name=description cols=80></textarea>

</p>

<p align=left><?php echo $MSG_Input?>:<br>
<textarea  class="kindeditor" rows=13 name=input cols=80></textarea>

</p>

</p>
<p align=left><?php echo $MSG_Output?><br>
<textarea  class="kindeditor" rows=13 name=output cols=80></textarea>



</p>
<p align=left><?php echo $MSG_Sample_Input?><textarea  class="input input-large"  rows=13 name=sample_input cols=40></textarea>
              <?php echo $MSG_Sample_Output?><textarea  class="input input-large"  rows=13 name=sample_output cols=40></textarea></p>
<p align=left><?php echo $MSG_Test_Input?><textarea  class="input input-large" rows=13 name=test_input cols=40></textarea>
              <?php echo $MSG_Test_Output?><textarea  class="input input-large"  rows=13 name=test_output cols=40></textarea></p>
<p align=left><?php echo $MSG_HELP_MORE_TESTDATA_LATER?></p>
<p align=left><?php echo $MSG_HINT?>:<br>
<textarea class="kindeditor" rows=13 name=hint cols=80></textarea>
</p>
<p><?php echo $MSG_SPJ?>: N<input type=radio name=spj value='0' checked>Y<input type=radio name=spj value='1'>
 <?php echo $MSG_HELP_SPJ?>
</p>
<p align=left><?php echo $MSG_Source?>:<br><textarea name=source rows=1 cols=70></textarea></p>
<p align=left><?php echo $MSG_CONTEST?>:
	<select  name=contest_id>
<?php

 $sql="SELECT `contest_id`,`title` FROM `contest` WHERE `start_time`>NOW() order by `contest_id`";
$result=pdo_query($sql);
echo "<option value=''>none</option>";
if (count($result)==0){
}else{
	foreach($result as $row){
		echo "<option value='{$row['contest_id']}'>{$row['contest_id']} {$row['title']}</option>";
	}
}
?>
	</select>
</p>
<div align=center>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value=Submit name=submit>
</div></form>
<p>
</div>
</body></html>

