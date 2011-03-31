<?require_once('oj-header.php');?>
<title>Export All AC Source</title>
<?
if (!isset($_SESSION['user_id'])){
	echo "<a href=./loginpage.php>Please LogIn First!</a>";
	require_once('oj-footer.php');
	exit();
}
require_once('./include/db_info.inc.php');
$sql="select distinct source,problem_id from source_code right join 
		(select solution_id,problem_id from solution where user_id='".$_SESSION['user_id']."' and result=4) S 
		on source_code.solution_id=S.solution_id order by problem_id";

$result=mysql_query($sql);
while($row=mysql_fetch_object($result)){
	echo "<h2>Problem".$row->problem_id."</h2>";
	echo "<pre>".htmlspecialchars($row->source)."<pre>";
	
}
mysql_free_result($result);
?>
<?require_once('oj-footer.php');?>
