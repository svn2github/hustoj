<?php
	$cache_time=1;
	$OJ_CACHE_SHARE=false;
    require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
    require_once('./include/const.inc.php');
	require_once('./include/setlang.php');
	$view_title=$MSG_SUBMIT;
 if (!isset($_SESSION['user_id'])){

	$view_errors= "<a href=loginpage.php>Please Login First</a>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}
if (isset($_GET['id'])){
	$id=intval($_GET['id']);
        $sample_sql="select sample_input,sample_output from problem where problem_id=$id";
}else if (isset($_GET['cid'])&&isset($_GET['pid'])){
	$cid=intval($_GET['cid']);$pid=intval($_GET['pid']);
        $sample_sql="select sample_input,sample_output from problem where problem_id in (select problem_id from contest_problem where contest_id=$cid and num=$pid)";
        
}else{
	$view_errors=  "<h2>No Such Problem!</h2>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}


 $view_src="";
 if(isset($_GET['sid'])){
	$sid=intval($_GET['sid']);
	$sql="SELECT * FROM `solution` WHERE `solution_id`=".$sid;
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	if ($row && $row->user_id==$_SESSION['user_id']) $ok=true;
	if (isset($_SESSION['source_browser'])) $ok=true;
	mysql_free_result($result);
	if ($ok==true){
		$sql="SELECT `source` FROM `source_code` WHERE `solution_id`='".$sid."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_object($result);
		if($row)
			$view_src=$row->source;
		mysql_free_result($result);
	}
	
 }
$view_sample_input="1 2";
$view_sample_output="3";
 if(isset($sample_sql)){
   //echo $sample_sql;
	$result=mysql_query($sample_sql);
	$row=mysql_fetch_array($result);
	$view_sample_input=$row[0];
	$view_sample_output=$row[1];
	mysql_free_result($result);
	
	
 }
 


/////////////////////////Template
require("template/".$OJ_TEMPLATE."/submitpage.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

