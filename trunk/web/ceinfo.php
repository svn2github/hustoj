<?php 
$cache_time=1;
require_once("oj-header.php")?>
<title>Compile Error Info</title>
<?php require_once("./include/db_info.inc.php");
require_once("./include/const.inc.php");
if (!isset($_GET['sid'])){
	echo "No such code!\n";
	require_once("oj-footer.php");
	exit(0);
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
	$sql="SELECT `error` FROM `compileinfo` WHERE `solution_id`='".$id."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	echo htmlspecialchars(str_replace("\n\r","\n",$row->error))."</pre>";
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
   pats[0]=/warning.*declaration of 'main' with no type/;
   exps[0]="C++标准中，main函数必须有返回值";
   pats[1]=/'.*' was not declared in this scope/;
   exps[1]="变量没有声明过，检查下是否拼写错误！";
   pats[2]=/main’ must return ‘int’/;
   exps[2]="在标准C语言中，main函数返回值类型必须是int，教材和VC中使用void是非标准的用法";
   pats[3]=/ .* was not declared in this scope/;
   exps[3]="函数或变量没有声明过就进行调用，检查下是否导入了正确的头文件";
   pats[4]=/printf.*was not declared in this scope/;
   exps[4]="printf函数没有声明过就进行调用，检查下是否导入了stdio.h或cstdio头文件";
   
   function explain(){
     //alert("asdf");
       var errmsg=document.getElementById("errtxt").innerHTML;
	   var expmsg="";
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
