<?php 
require_once("admin-header.php");

if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>

<div class="container">
<br> 
<br> 
<br> 
<br> 

<?php
if(isset($_POST['do'])){

require_once(dirname(__FILE__)."/../include/backup.php");

$config = array(
        'host' => $DB_HOST,
        'port' => 3306,
        'user' => $DB_USER,
        'password' => $DB_PASS,
        'database' => $DB_NAME,
        'charset' => 'utf-8',
        'target' => $OJ_DATA."/0/".$DB_NAME.(date('Y-m-d H:i:s')).".sql"
    );
$bak = new DatabaseTool($config);
$bak->backup();
?>
<button onclick="phpfm(0)" >查看备份文件</button>
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


<?php
}else{
?>
<br> 
<br> 
   <form method="post" action="backup.php">
	<input type="submit" name="do" value="Backup">
   </form>

<?php


}
?>

</div>
