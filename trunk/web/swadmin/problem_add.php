<?php
require_once ("admin-header.php");
require_once("../include/check_post_key.php");
if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

require_once ("../include/db_info.inc.php");
require_once ("../include/my_func.inc.php");
require_once ("../include/problem.php");

// contest_id
$title = $_POST['title'];
$title = str_replace(",", "&#44;", $title);
$time_limit = $_POST['time_limit'];
$memory_limit = $_POST['memory_limit'];

$description = $_POST['description'];
$description = str_replace("<p>", "", $description); 
$description = str_replace("</p>", "<br />", $description);
$description = str_replace(",", "&#44;", $description); 

$input = $_POST['input'];
$input = str_replace("<p>", "", $input); 
$input = str_replace("</p>", "<br />", $input); 
$input = str_replace(",", "&#44;", $input);

$output = $_POST['output'];
$output = str_replace("<p>", "", $output); 
$output = str_replace("</p>", "<br />", $output);
$output = str_replace(",", "&#44;", $output); 

$sample_input = $_POST['sample_input'];
$sample_output = $_POST['sample_output'];
$test_input = $_POST['test_input'];
$test_output = $_POST['test_output'];

$hint = $_POST['hint'];
$hint = str_replace("<p>", "", $hint); 
$hint = str_replace("</p>", "<br />", $hint); 
$hint = str_replace(",", "&#44;", $hint);

$source = $_POST['source'];

$spj = $_POST['spj'];


if(get_magic_quotes_gpc()){
  $title = stripslashes($title);
  $time_limit = stripslashes($time_limit);
  $memory_limit = stripslashes($memory_limit);
  $description = stripslashes($description);
  $input = stripslashes($input);
  $output = stripslashes($output);
  $sample_input = stripslashes($sample_input);
  $sample_output = stripslashes($sample_output);
  $test_input = stripslashes($test_input);
  $test_output = stripslashes($test_output);
  $hint = stripslashes($hint);
  $source = stripslashes($source);
  $spj = stripslashes($spj);
  $source = stripslashes($source);
}

$title = RemoveXSS($title);
$description = RemoveXSS($description);
$input = RemoveXSS($input);
$output = RemoveXSS($output);
$hint = RemoveXSS($hint);
//echo "->".$OJ_DATA."<-"; 
$pid = addproblem($title, $time_limit, $memory_limit, $description, $input, $output, $sample_input, $sample_output, $hint, $source, $spj, $OJ_DATA);
$basedir = "$OJ_DATA/$pid";
mkdir($basedir);
if(strlen($sample_output) && !strlen($sample_input)) $sample_input = "0";
if(strlen($sample_input)) mkdata($pid, "sample.in", $sample_input, $OJ_DATA);
if(strlen($sample_output)) mkdata($pid, "sample.out", $sample_output, $OJ_DATA);
if(strlen($test_output) && !strlen($test_input)) $test_input = "0";
if(strlen($test_input)) mkdata($pid,"test.in", $test_input, $OJ_DATA);
if(strlen($test_output)) mkdata($pid,"test.out", $test_output, $OJ_DATA);

$sql = "insert into `privilege` (`user_id`,`rightstr`) values(?,?)";
pdo_query($sql, $_SESSION[$OJ_NAME.'_'.'user_id'], "p$pid");
$_SESSION[$OJ_NAME.'_'."p$pid"] = true;
  
echo "<a href='javascript:phpfm($pid);'>Add more TestData now!</a>";
/*  */
?>

<script src='../template/bs3/jquery.min.js' ></script>
<script>
function phpfm(pid){
  //alert(pid);
  $.post("phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
    if(status=="success"){
      document.location.href="phpfm.php?frame=3&pid="+pid;
    }
  });
}
</script>
