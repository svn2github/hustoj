<?php session_start();
unset($_SESSION[$OJ_NAME.'_'.'user_id']);
session_destroy();
header("Location:index.php");
?>
