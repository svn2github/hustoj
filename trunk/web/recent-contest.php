<?php
$cache_time=60;
$OJ_CACHE_SHARE=true;
 require_once("oj-header.php");
	require_once("./include/db_info.inc.php");
	echo "<title>Recent Contests from Naikai-contest-spider</title>";
?>
<?php if(function_exists('apc_cache_info')): ?>
<?php $_apc_cache_info = apc_cache_info(); ?>
<?php endif;?>
<div align="center">
<?php
$local_file = 'contests.json';//local file of contests.json
$last_modified = filemtime($local_file);
if (time() - $last_modified > 1*60*60) {
    $json = @file_get_contents('http://202.113.25.50/contests.json');
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
?>

<table>
<thead>
	<tr>
		<th class="column-1">OJ</th><th class="column-2">Name</th><th class="column-3">Start Time</th><th class="column-4">Week</th><th class="column-5">Access</th>
	</tr>
</thead>
<tbody class="row-hover">
<? foreach ($rows as $row) : ?>
	<tr>
		<td class="column-1"><?=$row['oj']?></td><td class="column-2"><a id="name_<?=$row['id']?>" href="<?=$row['link']?>" target="_blank"><?=$row['name']?></a></td><td class="column-3"><?=$row['start_time']?></td><td class="column-4"><?=$row['week']?></td><td class="column-5"><?=$row['access']?></td>
	</tr>
<? endforeach; ?>
</tbody>
</table>
</div>
数据来源：http://contests.acmicpc.info/contests.json
<?php require('oj-footer.php');?>