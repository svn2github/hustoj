<?php
session_start();
$_SESSION[$OJ_NAME . '_' . 'OJ_LANG'] = $_GET['lang'];
setcookie("lang", $_GET['lang'], time() + 604800);
header("Location: " . $_GET['back'], true, 302);
?>