<?require_once("admin-header.php");?>

<form action='problem_export_xml.php' method=post>
	<b>Export Problem:</b><br />
	start pid:<input type=text size=10 name="start" value=1000><br />
	end pid:<input type=text size=10 name="end" value=1000><br />
	<input type='hidden' name='do' value='do'>
	<input type=submit value='Export'>
</form>
