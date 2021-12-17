<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/mario.css'type='text/css'>
</head>
<body>
<div id="wrapper">
	<?php
	if(isset($_GET['id']))
		require_once("oj-header.php");
	else
		require_once("contest-header.php");
	?>
<div id=main>
	<center>

<script src="include/checksource.js">
</script>
<form action="submit.php" method="post" 
<?php if($OJ_LANG=="cn"){?>
 onsubmit="return checksource(document.getElementById('source').value);"
<?php }?> 
 >
<?php if (isset($id)){?>
Problem <span class=blue><b><?php echo $id?></b></span><br>
<input type='hidden' value='<?php echo $id?>' name="id">
<?php }else{
$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
if ($pid>25) $pid=25;
?>
Problem <span class=blue><b><?php echo $PID[$pid]?></b></span> of Contest <span class=blue><b><?php echo $cid?></b></span><br>
<input type='hidden' value='<?php echo $cid?>' name="cid">
<input type='hidden' value='<?php echo $pid?>' name="pid">
<?php }?>
Language:
<select id="language" name="language">
<?php if(isset($_GET['langmask']))
	$langmask=$_GET['langmask'];
  else
	$langmask=$OJ_LANGMASK;
	
  $lang=(~((int)$langmask))&1023;
 $C_=($lang&1)>0;
 $CPP_=($lang&2)>0;
 $P_=($lang&4)>0;
 $J_=($lang&8)>0;
 $R_=($lang&16)>0;
 $B_=($lang&32)>0;
 $Y_=($lang&64)>0;
 $H_=($lang&128)>0;
 $L_=($lang&256)>0;
 $S_=($lang&512)>0;
 if(isset($_COOKIE['lastlang'])) $lastlang=$_COOKIE['lastlang'];
 else $lastlang=1;
 if($C_) echo"	    <option value=0 ".( $lastlang==0?"selected":"").">C</option>";
 if($CPP_) echo"	<option value=1 ".( $lastlang==1?"selected":"").">C++</option>";
 if($P_) echo"		<option value=2 ".( $lastlang==2?"selected":"").">Pascal</option>";
 if($J_) echo"		<option value=3 ".( $lastlang==3?"selected":"").">Java</option>";
 if($R_) echo"		<option value=4 ".( $lastlang==4?"selected":"").">Ruby</option>";
 if($B_) echo"		<option value=5 ".( $lastlang==5?"selected":"").">Bash</option>";
 if($Y_) echo"		<option value=6 ".( $lastlang==6?"selected":"").">Python</option>";
 if($H_) echo"		<option value=7 ".( $lastlang==7?"selected":"").">PHP</option>";
 if($L_) echo"		<option value=8 ".( $lastlang==8?"selected":"").">Perl</option>";
 if($S_) echo"		<option value=9 ".( $lastlang==9?"selected":"").">C-Sharp</option>";
 
?>
</select>
<br>
<textarea cols=80 rows=20 id="source" name="source"><?php echo $view_src?></textarea><br>
<input type=submit value="Submit">
<input type=reset value="Reset">
</form>
</center>
<div id=foot>
	<?php require_once("oj-footer.php");?>

</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
	<?php
if($OJ_ACE_EDITOR){
?>
<script src="ace/ace.js"></script>
<script src="ace/ext-language_tools.js"></script>
<script>
    ace.require("ace/ext/language_tools");
    var editor = ace.edit("source");
    editor.setTheme("ace/theme/chrome");
    switchLang(<?php echo $lastlang ?>);
    editor.setOptions({
	enableBasicAutocompletion: true,
        enableSnippets: true,
        enableLiveAutocompletion: false,
        fontFamily: "Consolas",
        fontSize: "20px"
    });
   reloadtemplate($("#language").val()); 
     
</script>
<?php }?>
</body>
</html>
