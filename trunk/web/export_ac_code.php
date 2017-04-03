<?php 
@session_start();
         header ( "content-type:   application/file" );
         header ( "content-disposition:   attachment;   filename=\"ac-".$_SESSION['user_id'].".txt" );
if (!isset($_SESSION['user_id'])){
	$view_errors= "<a href=./loginpage.php>$MSG_Login</a>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
}
require_once('./include/db_info.inc.php');
$sql="select distinct source,problem_id from source_code right join 
		(select solution_id,problem_id from solution where user_id='".$_SESSION['user_id']."' and result=4) S 
		on source_code.solution_id=S.solution_id order by problem_id";

$result=mysqli_query($mysqli,$sql);
while($row=mysqli_fetch_object($result)){
	echo "Problem".$row->problem_id.":\r\n";
	echo preg_replace("(\n)","\r\n",$row->source);
	echo "\r\n------------------------------------------------------\r\n";
}
mysqli_free_result($result);
?>
