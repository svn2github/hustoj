<?php
if (isset($_GET['lang']) && isset($_GET['back']) && in_array($_GET['lang'], array("cn", "en", 'fa', 'ko', 'th'))) {
    session_start();
    $_SESSION[$OJ_NAME . '_' . 'OJ_LANG'] = $_GET['lang'];
    setcookie("lang", $_GET['lang'], time() + 604800);
    header("Location: " . $_GET['back'], true, 302);
} else {
    http_response_code(400);
    echo "Bad Request";
}
?>