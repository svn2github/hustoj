<?php
require_once('./include/qqwry.php');
ip2location($_SERVER['REMOTE_ADDR']);


echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";

$browser = get_browser($_SERVER['HTTP_USER_AGENT'], true);
print_r($browser);
?> 

<?php
//	$b = get_browser();
//	var_dump($b);
//	phpinfo();
?>
