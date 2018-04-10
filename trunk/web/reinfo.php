<?php
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Welcome To Online Judge";
	
require_once("./include/const.inc.php");
if (!isset($_GET['sid'])){
	echo "No such code!\n";
	require_once("oj-footer.php");
	exit(0);
}
function is_valid($str2){
    return 1;
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
$sql="SELECT * FROM `solution` WHERE `solution_id`=?";
$result=pdo_query($sql,$id);
$row=$result[0];
$isRE=$row['result']==10;
if ($row && $row['user_id']==$_SESSION[$OJ_NAME.'_'.'user_id']) $ok=true;
if (isset($_SESSION[$OJ_NAME.'_'.'source_browser'])) $ok=true;
$view_reinfo="";
if ($ok==true){
	if($row['user_id']!=$_SESSION[$OJ_NAME.'_'.'user_id'])
		$view_mail_link= "<a href='mail.php?to_user=".htmlentities($row['user_id'],ENT_QUOTES,"UTF-8")."&title=$MSG_SUBMIT $id'>Mail the auther</a>";
	
	$sql="SELECT `error` FROM `runtimeinfo` WHERE `solution_id`=?";
	$result=pdo_query($sql,$id);
	 $row=$result[0];
	if($row&&($OJ_SHOW_DIFF||$isRE)&&($OJ_TEST_RUN||is_valid($row['error']))){	
		$view_reinfo= htmlentities(str_replace("\n\r","\n",$row['error']),ENT_QUOTES,"UTF-8");
	}else{
		
		$view_reinfo="sorry , not available (RE:".$isRE.",OJ_SHOW_DIFF:".$OJ_SHOW_DIFF.",TR:".$OJ_TEST_RUN.",valid:".is_valid($row['error']).")";
	}
        
	
}else{
	
	$view_errors= "I am sorry, You could not view this message!";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
	
}

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/reinfo.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

