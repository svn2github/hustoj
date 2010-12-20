<?require_once("oj-header.php")?>
<title>Source Code</title>

<link href='highlight/styles/shCore.css' rel='stylesheet' type='text/css'/> 
<link href='highlight/styles/shThemeDefault.css' rel='stylesheet' type='text/css'/> 
<script src='highlight/scripts/shCore.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushCpp.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushCSharp.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushCss.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushJava.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushDelphi.js' type='text/javascript'></script> 
<script src='highlight/scripts/shBrushRuby.js' type='text/javascript'></script> 
<script language='javascript'> 
SyntaxHighlighter.config.bloggerMode = false;
SyntaxHighlighter.config.clipboardSwf = 'highlight/scripts/clipboard.swf';
SyntaxHighlighter.all();
</script>

<?
require_once("./include/db_info.inc.php");
require_once("./include/const.inc.php");
if (!isset($_GET['id'])){
	echo "No such code!\n";
	require_once("oj-footer.php");
	exit(0);
}
$ok=false;
$id=strval(intval($_GET['id']));
$sql="SELECT * FROM `solution` WHERE `solution_id`='".$id."'";
$result=mysql_query($sql);
$row=mysql_fetch_object($result);
if ($row && $row->user_id==$_SESSION['user_id']) $ok=true;
if (isset($_SESSION['source_browser'])) $ok=true;
if ($ok==true){
	$brush=strtolower($language_name[$row->language]);
	if ($brush=='pascal') $brush='delphi';
	echo "<pre class=\"brush:".$brush.";\">";
	ob_start();
	echo "/**************************************************************\n";
	echo "\tProblem: $row->problem_id\n\tUser: $row->user_id\n";
	echo "\tLanguage: ".$language_name[$row->language]."\n\tResult: ".$judge_result[$row->result]."\n";
	if ($row->result==4){
		echo "\tTime:".$row->time." ms\n";
		echo "\tMemory:".$row->memory." kb\n";
	}
	echo "****************************************************************/\n\n";
	$auth=ob_get_contents();
	ob_end_clean();
	mysql_free_result($result);
	$sql="SELECT `source` FROM `source_code` WHERE `solution_id`='".$id."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	echo htmlspecialchars(str_replace("\n\r","\n",$row->source))."\n".$auth."</pre>";
	mysql_free_result($result);
}else{
	mysql_free_result($result);
	echo "I am sorry, You could not view this code!";
}
?>
<?require_once("oj-footer.php")?>
