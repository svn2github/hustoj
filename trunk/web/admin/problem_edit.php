<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit Problem</title>
</head>
<body>
<center>
<?php require_once("../include/db_info.inc.php");?>
<?php require_once("admin-header.php");

if (!(isset($_SESSION['administrator'])
      ||isset($_SESSION['problem_editor'])
     )){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php
include_once("kindeditor.php") ;
?>
<p align="center"><font color="#333399" size="4">Welcome To Administrator's Page of Judge Online of ACM ICPC, <?php echo $OJ_NAME?>.</font>
<td width="100"></td>
</center>
<hr>
<?php if(isset($_GET['id'])){
;//	require_once("../include/check_get_key.php");
?>
<h1>Edit problem</h1>
<form method=POST action=problem_edit.php>
<input type=hidden name=problem_id value=New Problem>
<?php $sql="SELECT * FROM `problem` WHERE `problem_id`=?";
$result=pdo_query($sql,intval($_GET['id']));
 $row=$result[0];
?>
<p>Problem Id: <?php echo $row['problem_id']?></p>
<input type=hidden name=problem_id value='<?php echo $row['problem_id']?>'>
<p>Title:<input type=text name=title size=71 value='<?php echo htmlentities($row['title'],ENT_QUOTES,"UTF-8")?>'></p>
<p>Time Limit:<input type=text name=time_limit size=20 value='<?php echo $row['time_limit']?>'>S</p>
<p>Memory Limit:<input type=text name=memory_limit size=20 value='<?php echo $row['memory_limit']?>'>MByte</p>
<p>Description:<br><textarea class="kindeditor" rows=13 name=description cols=120><?php echo htmlentities($row['description'],ENT_QUOTES,"UTF-8")?></textarea></p>
<p>Input:<br><textarea class="kindeditor" rows=13 name=input cols=120><?php echo htmlentities($row['input'],ENT_QUOTES,"UTF-8")?></textarea></p>
<p>Output:<br><textarea class="kindeditor" rows=13 name=output cols=120><?php echo htmlentities($row['output'],ENT_QUOTES,"UTF-8")?></textarea></p>

<p>Sample Input:<br><textarea rows=13 name=sample_input cols=120><?php echo htmlentities($row['sample_input'],ENT_QUOTES,"UTF-8")?></textarea></p>
<p>Sample Output:<br><textarea rows=13 name=sample_output cols=120><?php echo htmlentities($row['sample_output'],ENT_QUOTES,"UTF-8")?></textarea></p>
<p>Hint:<br>
<textarea class="kindeditor" rows=13 name=hint cols=120><?php echo htmlentities($row['hint'],ENT_QUOTES,"UTF-8")?></textarea></p>
</p>
<p>SpecialJudge: 
N<input type=radio name=spj value='0' <?php echo $row['spj']=="0"?"checked":""?>>
Y<input type=radio name=spj value='1' <?php echo $row['spj']=="1"?"checked":""?>></p>
<p>Source:<br><textarea name=source rows=1 cols=70><?php echo htmlentities($row['source'],ENT_QUOTES,"UTF-8")?></textarea></p>
<div align=center>
<?php require_once("../include/set_post_key.php");?>
<input type=submit value=Submit name=submit>
</div></form>
<p>

<?php }else{
require_once("../include/check_post_key.php");
$id=intval($_POST['problem_id']);
if(!(isset($_SESSION["p$id"])||isset($_SESSION['administrator']))) exit();	
$title=$_POST['title'];
$time_limit=$_POST['time_limit'];
$memory_limit=$_POST['memory_limit'];
$description=$_POST['description'];
$input=$_POST['input'];
$output=$_POST['output'];
$sample_input=$_POST['sample_input'];
$sample_output=$_POST['sample_output'];
$hint=$_POST['hint'];
$source=$_POST['source'];
$spj=$_POST['spj'];
if (get_magic_quotes_gpc ()) {
	$title = stripslashes ( $title);
	$time_limit = stripslashes ( $time_limit);
	$memory_limit = stripslashes ( $memory_limit);
	$description = stripslashes ( $description);
	$input = stripslashes ( $input);
	$output = stripslashes ( $output);
	$sample_input = stripslashes ( $sample_input);
	$sample_output = stripslashes ( $sample_output);
//	$test_input = stripslashes ( $test_input);
//	$test_output = stripslashes ( $test_output);
	$hint = stripslashes ( $hint);
	$source = stripslashes ( $source); 
	$spj = stripslashes ( $spj);
	$source = stripslashes ( $source );
}
$basedir=$OJ_DATA."/$id";
echo "Sample data file in $basedir Updated!<br>";

	if($sample_input&&file_exists($basedir."/sample.in")){
		//mkdir($basedir);
		$fp=fopen($basedir."/sample.in","w");
		fputs($fp,preg_replace("(\r\n)","\n",$sample_input));
		fclose($fp);
		
		$fp=fopen($basedir."/sample.out","w");
		fputs($fp,preg_replace("(\r\n)","\n",$sample_output));
		fclose($fp);
	}

	$spj=intval($spj);
	
$sql="UPDATE `problem` set `title`=?,`time_limit`=?,`memory_limit`=?,
	`description`=?,`input`=?,`output`=?,`sample_input`=?,`sample_output`=?,`hint`=?,`source`=?,`spj`=?,`in_date`=NOW()
	WHERE `problem_id`=?";

@pdo_query($sql,$title,$time_limit,$memory_limit,$description,$input,$output,$sample_input,$sample_output,$hint,$source,$spj,$id) ;
echo "Edit OK!";


		
echo "<a href='../problem.php?id=$id'>See The Problem!</a>";
}
?>
</body>
</html>

