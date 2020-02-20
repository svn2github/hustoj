<?php 
    require_once("../include/db_info.inc.php");
    require_once ("../include/my_func.inc.php");

	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
	$url=basename($_SERVER['REQUEST_URI']);
	$realurl=basename($_SERVER['REQUEST_URI']);
	$url=str_replace(strrchr($url, "?"),"",$url);
;?>
<link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
<link href="assets/css/lib/themify-icons.css" rel="stylesheet">
<link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
<link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
<link href="assets/css/lib/weather-icons.css" rel="stylesheet" />
<link href="assets/css/lib/mmc-chat.css" rel="stylesheet" />
<link href="assets/css/lib/sidebar.css" rel="stylesheet">
<link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/lib/simdahs.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/wangEditor/10.0.13/wangEditor.js"></script>

<?php 
if (!$_SESSION[$OJ_NAME.'_'.'administrator'] && !$_SESSION[$OJ_NAME.'_'.'problem_editor'] && !$_SESSION[$OJ_NAME.'_'.'contest_creator']) {
    $mod = 'hacker';
}
if ($_SESSION[$OJ_NAME.'_'.'contest_creator']) {
    $mod = 'contest_creator';
}
if ($_SESSION[$OJ_NAME.'_'.'problem_editor']) {
    $mod = 'problem_editor';
}
if ($_SESSION[$OJ_NAME.'_'.'administrator']) {
    $mod = 'administrator';
}
if ($mod == 'hacker') {
    ?><script src="assets/js/lib/jquery.min.js"></script><script>$.ajax({
    url: '../404.html',
    success: function(res){
        document.write(res);
    }
});</script><?php
    die();
}
?>
