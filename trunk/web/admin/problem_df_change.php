<?php require_once("admin-header.php");
require_once("../include/check_get_key.php");
if (!(isset($_SESSION['administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
?>
<?php $id=intval($_GET['id']);
$sql="SELECT `defunct` FROM `problem` WHERE `problem_id`=?";
$result=pdo_query($sql,$id);
$row=$result[0];
$defunct=$row[0];
echo $defunct;

if ($defunct=='Y') $sql="update `problem` set `defunct`='N' where `problem_id`=?";
else $sql="update `problem` set `defunct`='Y' where `problem_id`=?";
pdo_query($sql,$id) ;
?>
<script language=javascript>
	history.go(-1);
</script>
