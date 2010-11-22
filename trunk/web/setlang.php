<?
	require_once("./include/db_info.inc.php");
	$_SESSION['OJ_LANG']=$_GET['lang'];
		echo "<script language='javascript'>\n";
		echo "history.go(-1);\n";
		echo "</script>";
	
?>
