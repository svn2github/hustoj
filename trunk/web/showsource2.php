<?php
 $cache_time=90;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Source Code";
   
require_once("./include/const.inc.php");
if (!isset($_GET['id'])){
	$view_errors= "No such code!\n";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}
$ok=false;
$id=strval(intval($_GET['id']));
$sql="SELECT * FROM `solution` WHERE `solution_id`='".$id."'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);
$slanguage=$row->language;
$sresult=$row->result;
$stime=$row->time;
$smemory=$row->memory;
$sproblem_id=$row->problem_id;
$view_user_id=$suser_id=$row->user_id;
$contest_id=$row->contest_id;

mysqli_free_result($result);

if(isset($OJ_EXAM_CONTEST_ID)){
	if($contest_id<$OJ_EXAM_CONTEST_ID&&!isset($_SESSION['source_browser'])){
	header("Content-type: text/html; charset=utf-8");
	 echo $MSG_SOURCE_NOT_ALLOWED_FOR_EXAM;
	 exit();
	}
}

if (isset($OJ_AUTO_SHARE)&&$OJ_AUTO_SHARE&&isset($_SESSION['user_id'])){
	$sql="SELECT 1 FROM solution where 
			result=4 and problem_id=$sproblem_id and user_id='".$_SESSION['user_id']."'";
	$rrs=mysqli_query($mysqli,$sql);
	$ok=(mysqli_num_rows($rrs)>0);
	mysqli_free_result($rrs);
}
$view_source="No source code available!";
if (isset($_SESSION['user_id'])&&$row && $row->user_id==$_SESSION['user_id']) $ok=true;
if (isset($_SESSION['source_browser'])) $ok=true;

		$sql="SELECT `source` FROM `source_code_user` WHERE `solution_id`=".$id;
		$result=mysqli_query($mysqli,$sql);
		$row=mysqli_fetch_object($result);
		if($row)
			$view_source=$row->source;

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/showsource2.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

