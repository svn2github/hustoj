<?require_once("admin-header.php");?>
<?require_once("../include/db_info.inc.php");?>
<?require_once("../include/problem.php");?>
<?
// contest_id

$title=$_POST['title'];
$time_limit=$_POST['time_limit'];
$memory_limit=$_POST['memory_limit'];
$description=$_POST['description'];
$input=$_POST['input'];
$output=$_POST['output'];
$sample_input=$_POST['sample_input'];
$sample_output=$_POST['sample_output'];
$test_input=$_POST['test_input'];
$test_output=$_POST['test_output'];
$hint=$_POST['hint'];
$source=$_POST['source'];
$spj=$_POST['spj'];
//echo "->".$OJ_DATA."<-"; 
addproblem ( $title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $test_input, $test_output, $hint, $source, $spj,$OJ_DATA );

/*	*/
?>
<?require_once("../oj-footer.php");


?>

