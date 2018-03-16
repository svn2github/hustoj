<?php require("admin-header.php");
require_once("../include/set_get_key.php");
if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
echo "<title>Privilege List</title>"; 
echo "<div class='container'>";
$sql="select * FROM privilege where rightstr in ('administrator','source_browser','contest_creator','http_judge','problem_editor','password_setter','printer','balloon') ";
$result=pdo_query($sql) ;
echo "<center><table class='table table-striped' width=60% border=1>";
echo "<thead><tr><td>user<td>right<td>defunc</tr></thead>";
foreach($result as $row){
	echo "<tr>";
	echo "<td>".$row['user_id'];
	echo "<td>".$row['rightstr'];
//	echo "<td>".$row['start_time'];
//	echo "<td>".$row['end_time'];
//	echo "<td><a href=contest_pr_change.php?cid=$row['contest_id']>".($row['private']=="0"?"Public->Private":"Private->Public")."</a>";
	echo "<td><a href=privilege_delete.php?uid={$row['user_id']}&rightstr={$row['rightstr']}&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">Delete</a>";
//	echo "<td><a href=contest_edit.php?cid=$row['contest_id']>Edit</a>";
//	echo "<td><a href=contest_add.php?cid=$row['contest_id']>Copy</a>";
	echo "</tr>";
}
echo "</table></center></div>";

?>
