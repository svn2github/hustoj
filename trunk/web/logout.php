<?php session_start();
unset($_SESSION[$OJ_NAME.'_'.'user_id']);
session_destroy();
setcookie($OJ_NAME."_user",'');
setcookie($OJ_NAME."_check",'');
header("Location:index.php");
?>
