<?session_start();?>
<title>Submit Code</title>
<?
if (!isset($_SESSION['user_id'])){
	echo "<a href=loginpage.php>Please Login First</a>";
	require_once("oj-footer.php");
	exit(0);
}
if (isset($_GET['id'])){
	$id=intval($_GET['id']);
	require_once("oj-header.php");
}else if (isset($_GET['cid'])&&isset($_GET['pid'])){
	require_once("contest-header.php");
	$cid=intval($_GET['cid']);$pid=intval($_GET['pid']);
}
else{
	echo "<h2>No Such Problem!</h2>";
	require_once("oj-footer.php");
	exit(0);
}
?>
<center>
<script>
	function checksource(src){
		var keys=new Array();
		var errs=new Array();
		var msg="";
		keys[0]="void main";
		errs[0]="main函数返回值不能为void,否则会编译出错。\n很多人甚至市面上的一些书籍，都使用了void main( ) ，其实这是错误的。\nC/C++ 中从来没有定义过void main( ) 。\nC++ 之父 Bjarne Stroustrup 在他的主页上的 FAQ 中明确地写着\n The definition void main( ) { /* ... */ } is not and never has been C++,\n nor has it even been C.\n（ void main( ) 从来就不存在于 C++ 或者 C ）。";
		keys[1]="Please";
		errs[1]="除非题目要求，否则不要使用类似‘Please input’这样的提示，";		
		keys[2]="请";
		errs[2]="除非题目要求，否则不要使用类似‘请输入’这样的提示，";		
		keys[3]="输入";
		errs[3]="除非题目要求，否则不要使用类似‘请输入’这样的提示，";		
		keys[3]="input";
		errs[3]="除非题目要求，否则不要使用类似‘Please input’这样的提示，";		
		for(var i=0;i<keys.length;i++){
			if(src.indexOf(keys[i])!=-1){
				msg+=errs[i]+"\n";
			}
		}
		if(msg.length>0)
			return confirm(msg+"\n 代码可能有错误，确定要提交么？");					
		else
			return true;
}
</script>
<form action="submit.php" method="post"  onsubmit="return checksource(document.getElementById('source').value);">
<?if (isset($id)){?>
Problem <font color=blue><b><?=$id?></b></font><br>
<input type='hidden' value='<?=$id?>' name="id">
<?
}else{
$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if ($pid>25) $pid=25;
?>
Problem <font color=blue><b><?=$PID[$pid]?></b></font> of Contest <font color=blue><b><?=$cid?></b></font><br>
<input type='hidden' value='<?=$cid?>' name="cid">
<input type='hidden' value='<?=$pid?>' name="pid">
<?}?>
Language:
<select name="language">
	<option value=0>C</option>
	<option value=1 selected>C++</option>
	<option value=2>Pascal</option>
	<option value=3>Java</option>
</select>
<br>
<textarea cols=80 rows=35 id="source" name="source"></textarea><br>
<input type=hidden name=testquote value='"'>
<input type=submit value="Submit">
<input type=reset value="Reset">
</form>
</center>
<?require_once("oj-footer.php")?>

