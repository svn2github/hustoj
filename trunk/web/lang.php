<?php
setcookie("lang", $_GET['lang'], time() + 604800);
header("Location: " . $_GET['back'], true, 302);
?>