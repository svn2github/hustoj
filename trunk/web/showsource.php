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
<script src='highlight/scripts/shBrushBash.js' type='text/javascript'></script>
<script src='highlight/scripts/shBrushPython.js' type='text/javascript'></script> 
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
$slanguage=$row->language;
$sresult=$row->result;
$stime=$row->time;
$smemory=$row->memory;
$sproblem_id=$row->problem_id;
$suser_id=$row->user_id;



if (isset($OJ_AUTO_SHARE)&&$OJ_AUTO_SHARE&&isset($_SESSION['user_id'])){
	$sql="SELECT 1 FROM solution where 
			result=4 and problem_id=$sproblem_id and user_id='".$_SESSION['user_id']."'";
	$rrs=mysql_query($sql);
	$ok=(mysql_num_rows($rrs)>0);
}

if (isset($_SESSION['user_id'])&&$row && $row->user_id==$_SESSION['user_id']) $ok=true;
if (isset($_SESSION['source_browser'])) $ok=true;



if ($ok==true){
	$brush=strtolower($language_name[$row->language]);
	if ($brush=='pascal') $brush='delphi';
	echo "<pre class=\"brush:".$brush.";\">";
	ob_start();
	echo "/**************************************************************\n";
	echo "\tProblem: $sproblem_id\n\tUser: $suser_id\n";
	echo "\tLanguage: ".$language_name[$slanguage]."\n\tResult: ".$judge_result[$row->result]."\n";
	if ($sresult==4){
		echo "\tTime:".$stime." ms\n";
		echo "\tMemory:".$smemory." kb\n";
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
