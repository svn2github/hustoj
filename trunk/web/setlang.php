<?php
if (isset($_GET['lang']) && in_array($_GET['lang'], array("cn","ug", "en", 'fa', 'ko', 'th'))) {
    session_start();
    $_SESSION[$OJ_NAME . '_' . 'OJ_LANG'] = $_GET['lang'];
    setcookie("lang", $_GET['lang'], time() + 604800);
}
?>
<script>
    window.history.go(-1);
</script>
