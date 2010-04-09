<?require_once("admin-header.php");?>
Import FPS data ,please make sure you file is smaller than the [upload_max_filesize] in PHP.ini
<br>
<form action='problem_import_xml.php' method=post enctype="multipart/form-data">
	<b>Import Problem:</b><br />
	
	<input type=file name=fps >
    <input type=submit value='Import'>
</form>
