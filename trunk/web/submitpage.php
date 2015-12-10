<?php
	$cache_time=1;
	$OJ_CACHE_SHARE=false;
    require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
    require_once('./include/const.inc.php');
	require_once('./include/setlang.php');
	$view_title=$MSG_SUBMIT;
 if (!isset($_SESSION['user_id'])){

	$view_errors= "<a href=loginpage.php>$MSG_Login</a>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
//	$_SESSION['user_id']="Guest";
}
if (isset($_GET['id'])){
	$id=intval($_GET['id']);
        $sample_sql="select sample_input,sample_output,problem_id from problem where problem_id=$id";
}else if (isset($_GET['cid'])&&isset($_GET['pid'])){
	$cid=intval($_GET['cid']);$pid=intval($_GET['pid']);
        $sample_sql="select sample_input,sample_output,problem_id from problem where problem_id in (select problem_id from contest_problem where contest_id=$cid and num=$pid)";
        
}else{
	$view_errors=  "<h2>No Such Problem!</h2>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}


 $view_src="";
 if(isset($_GET['sid'])){
	$sid=intval($_GET['sid']);
	$sql="SELECT * FROM `solution` WHERE `solution_id`=".$sid;
	$result=mysqli_query($mysqli,$sql);
	$row=mysqli_fetch_object($result);
	if ($row && $row->user_id==$_SESSION['user_id']) $ok=true;
	if (isset($_SESSION['source_browser'])) $ok=true;
	mysqli_free_result($result);
	if ($ok==true){
		$sql="SELECT `source` FROM `source_code_user` WHERE `solution_id`='".$sid."'";
		$result=mysqli_query($mysqli,$sql);
		$row=mysqli_fetch_object($result);
		if($row)
			$view_src=$row->source;
		mysqli_free_result($result);
	}
	
 }
$problem_id=$id;
$view_sample_input="1 2";
$view_sample_output="3";
 if(isset($sample_sql)){
   //echo $sample_sql;
	$result=mysqli_query($mysqli,$sample_sql);
	$row=mysqli_fetch_array($result);
	$view_sample_input=$row[0];
	$view_sample_output=$row[1];
	$problem_id=$row[2];
	mysqli_free_result($result);
	
	
 }
 
if(!$view_src){
	if(isset($_COOKIE['lastlang'])) 
		$lastlang=intval($_COOKIE['lastlang']);
	else 
		$lastlang=0;
   $template_file="$OJ_DATA/$problem_id/template.".$language_ext[$lastlang];
   if(file_exists($template_file)){
	$view_src=file_get_contents($template_file);
   }

}


/////////////////////////Template
require("template/".$OJ_TEMPLATE."/submitpage.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

