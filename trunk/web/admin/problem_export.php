<?require_once("admin-header.php");?>
<?
if($_POST['do']=='do'){
	$start=addslashes($_POST['start']);
	$end=addslashes($_POST['end']);
	$sql="update `solution` set `user_id`='$to' where `user_id`='$from' and problem_id>=$start and problem_id<=$end and result=4";
	echo $sql;
	//mysql_query($sql);
	//echo mysql_affected_rows()." source file given!";
	
}
?>
<form action='problem_export_xml.php' method=post>
	<b>Export Problem:</b><br />
	start pid:<input type=text size=10 name="start"><br />
	end pid:<input type=text size=10 name="end"><br />
	<input type='hidden' name='do' value='do'>
	<input type=submit value='Export'>
</form>
