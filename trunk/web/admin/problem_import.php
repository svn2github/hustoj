<?require_once("admin-header.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
   $maxfile=min(ini_get("upload_max_filesize"),ini_get("post_max_size"));

?>
Import FPS data ,please make sure you file is smaller than [<?=$maxfile?>] <br/>
or set upload_max_filesize and post_max_size in PHP.ini

<?php 
   if(strstr(ini_get("open_basedir"),$OJ_DATA)){

?>
<br>
<form action='problem_import_xml.php' method=post enctype="multipart/form-data">
	<b>Import Problem:</b><br />
	
	<input type=file name=fps >
    <input type=submit value='Import'>
</form>
<?php 
   }else{
   	 echo $OJ_DATA." is not in your open_basedir setting of php.ini, you can't use import function"; 
   	}
   
?>
<br>

free problem set FPS-xml can be download at <a href=http://code.google.com/p/freeproblemset/downloads/list>FPS-Googlecode</a>
