<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php 
function deleteDir($dir)
{
if (rmdir($dir)==false && is_dir($dir)) {
 if ($dp = opendir($dir)) {
  while (($file=readdir($dp)) != false) {
   if (is_dir($file) && $file!='.' && $file!='..') {
    deleteDir($file);
   } else {
    unlink($file);
   }
  }
  closedir($dp);
 } else {
  exit('Not permission');
 }
} 
}

$id=intval($_GET['id']);

$basedir = "$OJ_DATA/$id";
deleteDir($basedir);
$sql="delete FROM `problem` WHERE `problem_id`=$id";
mysql_query($sql) or die(mysql_error());
$sql="select max(problem_id) FROM `problem` ;
mysql_query($sql);
$row=mysql_fetch_row($result);
$max_id=$row[0];
$max_id++;
mysql_free_result($result);
$sql="ALTER TABLE problem AUTO_INCREMENT = $max_id;";
mysql_query($sql);
?>
<script language=javascript>
	history.go(-1);
</script>
