<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
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
<?php
if($OJ_EDITE_AREA){
?>
<script language="Javascript" type="text/javascript" src="edit_area/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript">

editAreaLoader.init({
	        id: "source"            
	        ,start_highlight: true 
	        ,allow_resize: "both"
	        ,allow_toggle: true
	        ,word_wrap: true
	        ,language: "en"
	        ,syntax: "cpp"  
			,font_size: "8"
	        ,syntax_selection_allow: "basic,c,cpp,java,pas,perl,php,python,ruby"
			,toolbar: "search, go_to_line, fullscreen, |, undo, redo, |, select_font,syntax_selection,|, change_smooth_selection, highlight, reset_highlight, word_wrap, |, help"          
	});
</script>
<?php }?>
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
<?php 
$lang_count=count($language_ext);

  if(isset($_GET['langmask']))
	$langmask=$_GET['langmask'];
  else
	$langmask=$OJ_LANGMASK;
	
  $lang=(~((int)$langmask))&((1<<($lang_count))-1);
if(isset($_COOKIE['lastlang'])) $lastlang=$_COOKIE['lastlang'];
 else $lastlang=0;
 for($i=0;$i<$lang_count;$i++){ 
 		if($lang&(1<<$i))
		 echo"<option value=$i ".( $lastlang==$i?"selected":"").">
			".$language_name[$i]."
		 </option>";
  }

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
</body>
</html>
