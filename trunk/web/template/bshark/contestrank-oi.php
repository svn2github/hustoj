<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>OI<?php echo $MSG_STANDING;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4><?php echo $title?> - <?php echo $MSG_STANDING;?>(OI)</h4>
    <ul class="pagination">
    <li class="page-item"><a class="page-link" href='contest.php?cid=<?php echo $cid?>'><?php echo $MSG_CONTEST;?>C<?php echo $cid;?></a></li>
    <li class="page-item"><a class="page-link" href='status.php?cid=<?php echo $cid?>'><?php echo $MSG_STATUS;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank.php?cid=<?php echo $cid?>'><?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='contestrank-oi.php?cid=<?php echo $cid?>'>OI-<?php echo $MSG_STANDING;?></a></li>
    <li class="page-item"><a class="page-link" href='conteststatistics.php?cid=<?php echo $cid?>'><?php echo $MSG_STATISTICS;?></a></li>
    </ul>
<a class="btn btn-outline-dark" href="contestrank.xls.php?cid=<?php echo $cid?>" >Download xls file</a>
<table id=rank class="table table-hover"><thead><tr class=toprow align=center>
              <td class="{sorter:'false'}"><?php echo $MSG_STANDING?></td>
              <th><?php echo $MSG_USER?></th>
              <th><?php echo $MSG_NICK?></th>
              <th><?php echo $MSG_SOVLED?></th>
              <th><?php echo $MSG_CONTEST_PENALTY?></th>
              <th align="center">Mark</th>
<?php
$rank=1;
for ($i=0;$i<$pid_cnt;$i++)
echo "<td><a href=problem.php?cid=$cid&pid=$i>$PID[$i]</a></td>";
echo "</tr></thead>\n<tbody>";
for ($i=0;$i<$user_cnt;$i++){
if ($i&1) echo "<tr class=oddrow align=center>\n";
else echo "<tr class=evenrow align=center>\n";
echo "<td>";
$uuid=$U[$i]->user_id;
$nick=$U[$i]->nick;
if($nick[0]!="*")
echo $rank++;
else
echo "*";
$usolved=$U[$i]->solved;
if(isset($_GET['user_id'])&&$uuid==$_GET['user_id']) echo "<td bgcolor=#ffff77>";
else echo"<td>";
echo "<a name=\"$uuid\" href=userinfo.php?user=$uuid>$uuid</a>";
echo "<td><a href=userinfo.php?user=$uuid>".htmlentities($U[$i]->nick,ENT_QUOTES,"UTF-8")."</a>";
echo "<td><a href=status.php?user_id=$uuid&cid=$cid>$usolved</a>";
echo "<td>".sec2str($U[$i]->time);
echo "<td>".($U[$i]->total);
for ($j=0;$j<$pid_cnt;$j++){
$bg_color="eeeeee";
if (isset($U[$i]->p_ac_sec[$j])&&$U[$i]->p_ac_sec[$j]>0){
$aa=0x33+$U[$i]->p_wa_num[$j]*32;
$aa=$aa>0xaa?0xaa:$aa;
$aa=dechex($aa);
$bg_color="$aa"."ff"."$aa";
//$bg_color="aaffaa";
if($uuid==$first_blood[$j]){
$bg_color="aaaaff";
}
}else if(isset($U[$i]->p_wa_num[$j])&&$U[$i]->p_wa_num[$j]>0) {
$aa=0xaa-$U[$i]->p_wa_num[$j]*10;
$aa=$aa>16?$aa:16;
$aa=dechex($aa);
$bg_color="ff$aa$aa";
}
echo "<td class=well style='background-color:#$bg_color'>";
if(isset($U[$i])){
if (isset($U[$i]->p_ac_sec[$j])&&$U[$i]->p_ac_sec[$j]>0)
echo sec2str($U[$i]->p_ac_sec[$j]);
else if (isset($U[$i]->p_wa_num[$j])&&$U[$i]->p_wa_num[$j]>0)
echo "(+"+$U[$i]->p_pass_rate[$j]*100+")";
}
}
echo "</tr>\n";
}
echo "</tbody></table>";
?>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
