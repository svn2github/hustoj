<?php

$cache_time=1;
 require_once("oj-header.php")?>
<title>Running Error Info</title>
<?php require_once("./include/db_info.inc.php");
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
	echo "<pre id='errtxt'>";
	mysql_free_result($result);
	$sql="SELECT `error` FROM `runtimeinfo` WHERE `solution_id`='".$id."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	if(is_valid($row->error))	
		echo htmlspecialchars(str_replace("\n\r","\n",$row->error));
	echo "</pre>";
        
        echo "<div id='errexp'>Explain:</div>";
	mysql_free_result($result);
}else{
	mysql_free_result($result);
	echo "I am sorry, You could not view this message!";
}
?>
<script>
   var pats=new Array();
   var exps=new Array();
   pats[0]=/A Not allowed system call.* /;
   exps[0]="使用了系统禁止的操作系统调用，看看是否越权访问了文件或进程等资源";
   pats[1]=/Segmentation fault/;
   exps[1]="段错误，检查是否有数组越界，指针异常，访问到不应该访问的内存区域";
   pats[2]=/Floating point exception/;
   exps[2]="浮点错误，检查是否有除以零的情况";
   pats[3]=/buffer overflow detected/;
   exps[3]="缓冲区溢出，检查是否有字符串长度超出数组的情况";
   pats[4]=/Killed/;
   exps[4]="进程因为内存或时间原因被杀死，检查是否有死循环";
   pats[5]=/Alarm clock/;
   exps[5]="进程因为时间原因被杀死，检查是否有死循环，本错误等价于超时TLE";
   
  
   
   function explain(){
     //alert("asdf");
       var errmsg=document.getElementById("errtxt").innerHTML;
	   var expmsg="辅助解释：<br>";
	   for(var i=0;i<pats.length;i++){
		   var pat=pats[i];
		   var exp=exps[i];
		   var ret=pat.exec(errmsg);
		   if(ret){
		      expmsg+=ret+":"+exp+"<br>";
		   }
	   }
	   document.getElementById("errexp").innerHTML=expmsg;
     //alert(expmsg);
   }
   explain();
 
 </script>

<?php require_once("oj-footer.php")?>
