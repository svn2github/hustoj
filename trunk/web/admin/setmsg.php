<?
require_once("admin-header.php");
$fp=fopen("msg.txt","w");
fputs($fp, stripslashes($_POST['msg']));
fclose($fp);
echo "Update At ".date('Y-m-d h:i:s');
require_once('../oj-footer.php');
?>
