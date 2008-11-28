<?require_once("admin-header.php");?>
<?
$user_id=addslashes($_POST['user_id']);
$passwd =MD5($_POST['passwd']);
$sql="update `users` set `password`='$passwd' where `user_id`='$user_id'";
mysql_query($sql);
if (mysql_affected_rows()==1) echo "Password Changed!";
else echo "No such user!";
?>
<br><a href="./">Back To Admin Index</a>
