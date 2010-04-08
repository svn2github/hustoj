<?php
	$debug = true;
	require_once('./oj-header.php');
	require_once('./include/iplocation.php');

	$users = $on->getAll();
	$ip = new IpLocation();
?>
<h3>current online user: <?=$on->get_num()?></h3>
<table style="margin:auto;width:98%">
<thead>
<tr><th style="width: 50px">ip</th><th>uri</th><th>refer</th><th style="width:100px">stay time</th><th>user agent</th></tr>
</thead>
<tbody>
<?php foreach($users as $u): ?>
<tr><td class="ip"><?php $l = $ip->getlocation($u->ip); echo $u->ip.'<br />';echo $l['area'].'@'.$l['country'];?></td><td><?=$u->uri?></td><td><?=$u->refer?></td>
<td class="time"><?=sprintf("%dmin %dsec",($u->lastmove-$u->firsttime)/60,($u->lastmove-$u->firsttime) % 60)?></td><td><?php $b=get_browser($u->ua, false);echo $b->browser.$b->version.'@'.$b->platform;?></td></tr>
<?php endforeach;?>
</tbody>
</table>
<?php require_once('oj-footer.php')?>
