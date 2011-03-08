<?
function writable($path){
	$ret=false;
	$fp=fopen($path."/testifwritable.tst","w");
	$ret=!($fp===false);
	fclose($fp);
	unlink($path."/testifwritable.tst");
	return $ret;
}
require_once("admin-header.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
   $maxfile=min(ini_get("upload_max_filesize"),ini_get("post_max_size"));

?>
Import FPS data ,please make sure you file is smaller than [<?=$maxfile?>] <br/>
or set upload_max_filesize and post_max_size in PHP.ini<br/>
if you fail on import big files[10M+],try enlarge your [memory_limit]  setting in php.ini.<br>
<?php 
   if(!strstr(ini_get("open_basedir"),$OJ_DATA)){
 	   echo $OJ_DATA." is not in your open_basedir setting of php.ini, you can't use import function.<br>"; 
   }else if(!writable("../upload")){
       echo "../upload is not writable, chmod 770 to it.<br>";
   }else{
?>
<br>
<form action='problem_import_xml.php' method=post enctype="multipart/form-data">
	<b>Import Problem:</b><br />
	
	<input type=file name=fps >
	<?require_once("../include/set_post_key.php");?>
    <input type=submit value='Import'>
</form>
<?php 
  
   		}
   
?>
<br>

free problem set FPS-xml can be download at <a href=http://code.google.com/p/freeproblemset/downloads/list>FPS-Googlecode</a>
