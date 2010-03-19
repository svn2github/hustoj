<?require_once("admin-header.php");?>
<?require_once("../include/db_info.inc.php");?>
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

$sql="INSERT into `problem` (`title`,`time_limit`,`memory_limit`,
	`description`,`input`,`output`,`sample_input`,`sample_output`,`hint`,`source`,`spj`,`in_date`,`defunct`)
	VALUES('$title','$time_limit','$memory_limit','$description','$input','$output',
			'$sample_input','$sample_output','$hint','$source','$spj',NOW(),'Y')";

@mysql_query($sql) or die(mysql_error());
$pid=mysql_insert_id();
echo "Add $pid <br>";
if (intval($_POST['contest_id'])>999){
	$sql="select count(*) FROM `contest_problem` WHERE `contest_id`=".strval(intval($_POST['contest_id']));
	$result=@mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_row($result);
	$cid=$_POST['contest_id'];
	$num=$row[0];
	echo "Num=".$num."<br>";
	$sql="INSERT INTO `contest_problem` (`problem_id`,`contest_id`,`num`) VALUES('$pid','$cid','$num')";
	mysql_free_result($result);
	mysql_query($sql);
}
$basedir="/home/judge/data/$pid";
echo "Please add more data file in $basedir";

	mkdir($basedir);
	$fp=fopen($basedir."/sample.in","w");
	fputs($fp,ereg_replace("\r\n","\n",$sample_input));
	fclose($fp);
	
	$fp=fopen($basedir."/sample.out","w");
	fputs($fp,ereg_replace("\r\n","\n",$sample_output));
	fclose($fp);
	
	if(strlen($test_output)>0){
		$fp=fopen($basedir."/test.in","w");
		fputs($fp,ereg_replace("\r\n","\n",$test_input));
		fclose($fp);
		
		$fp=fopen($basedir."/test.out","w");
		fputs($fp,ereg_replace("\r\n","\n",$test_output));
		fclose($fp);
	
	
	}
/*	*/
?>
<?require_once("../oj-footer.php");?>

