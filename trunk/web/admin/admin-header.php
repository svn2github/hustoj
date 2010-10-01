<?session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if (!(isset($_SESSION['administrator'])||isset($_SESSION['contest_creator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
require_once("../include/db_info.inc.php");
?>

