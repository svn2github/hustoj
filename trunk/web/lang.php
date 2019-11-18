<?php
if (isset($_GET['lang']) && in_array($_GET['lang'], array("cn", "en", 'fa', 'ko', 'th'))) {
    session_start();
    $_SESSION[$OJ_NAME . '_' . 'OJ_LANG'] = $_GET['lang'];
    setcookie("lang", $_GET['lang'], time() + 604800);
    if (isset($_GET['back']) && !empty($_GET['back'])) {
        header("Location: " . $_GET['back'], true, 302);
    } else {
        header("Location: " . "index.php", true, 302);
    }
} else {
    http_response_code(400);
    echo "Bad Request";
}
?>