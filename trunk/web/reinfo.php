<?php

$cache_time=1;
 require_once("oj-header.php")?>
<title>Compile Error Info</title>
<?php 
require_once("./include/db_info.inc.php");
require_once("./include/const.inc.php");
if (!isset($_GET['sid'])){
	echo "No such code!\n";
	require_once("oj-footer.php");
	exit(0);
}
function is_valid($str2){
    $n=strlen($str2);
    $str=str_split($str2);
    $m=1;
    for($i=0;$i<$n;$i++){
    	if(is_numeric($str[$i])) $m++;
    }
    return $n/$m>3;
}


$ok=false;
$id=strval(intval($_GET['sid']));
$sql="SELECT * FROM `solution` WHERE `solution_id`='".$id."'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
if ($row && $row->user_id==$_SESSION['user_id']) $ok=true;
if (isset($_SESSION['source_browser'])) $ok=true;
if ($ok==true){
	if($row->user_id!=$_SESSION['user_id'])
		echo "<a href='mail.php?to_user=$row->user_id&title=$MSG_SUBMIT $id'>Mail the auther</a>";
	echo "<pre>";
	mysql_free_result($result);
	$sql="SELECT `error` FROM `runtimeinfo` WHERE `solution_id`='".$id."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	if(is_valid($row->error))	
		echo htmlspecialchars(str_replace("\n\r","\n",$row->error));
	echo "</pre>";
	mysql_free_result($result);
}else{
	mysql_free_result($result);
	echo "I am sorry, You could not view this message!";
}
?>
<?php require_once("oj-footer.php")?>
