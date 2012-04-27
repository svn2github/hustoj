<?php
////////////////////////////Common head
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= "Recent Contests from Naikai-contest-spider";

  $local_file = 'cache/contests.json';//local file of contests.json
$last_modified = filemtime($local_file);
if (time() - $last_modified > 1*60*60) {
    $json = @file_get_contents('http://contests.acmicpc.info/contests.json');
    if ($json) {
        file_put_contents($local_file, $json);
    }
    else {
        $json = file_get_contents($local_file);
        touch($local_file, time());
    }
}
else {
    $json = file_get_contents($local_file);
}

$rows = json_decode($json, true);



/////////////////////////Template
require("template/".$OJ_TEMPLATE."/recent-contest.html");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

?>


