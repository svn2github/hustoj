<?
require_once("admin-header.php");
if($_POST['do']=='do'){
	$fp=fopen("msg.txt","w");
	fputs($fp, stripslashes($_POST['msg']));
	fclose($fp);
	echo "Update At ".date('Y-m-d h:i:s');
}


$msg=file_get_contents("msg.txt");

?>
	<b>Set Message</b>
	<form action='setmsg.php' method='post'>
		<textarea name='msg' rows=25 cols=60><?=$msg?></textarea><br>
		<input type='hidden' name='do' value='do'>
		<input type='submit' value='change'>
	</form>
	
<?
require_once('../oj-footer.php');
?>
