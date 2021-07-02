<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv='refresh' content='60'>
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/mario.css'type='text/css'>
</head>
<body>
<div id="wrapper"> <?php require_once("oj-header.php");?>
<div id=main>
<div id=center>
<form id=simform action="status.php" method="get">
<?php echo $MSG_PROBLEM_ID?>:<input type=text size=4 name=problem_id value='<?php echo $problem_id?>'>
<?php echo $MSG_USER?>:<input type=text size=4 name=user_id value='<?php echo $user_id?>'>
<?php if (isset($cid)) echo "<input type='hidden' name='cid' value='$cid'>";?>
<?php echo $MSG_LANG?>:<select size="1" name="language">
<?php if (isset($_GET['language'])) $language=$_GET['language'];
else $language=-1;
if ($language<0||$language>9) $language=-1;
if ($language==-1) echo "<option value='-1' selected>All</option>";
else echo "<option value='-1'>All</option>";
for ($i=0;$i<10;$i++){
        if ($i==$language) echo "<option value=$i selected>$language_name[$i]</option>";
        else echo "<option value=$i>$language_name[$i]</option>";
}
?>
</select>
<?php echo $MSG_RESULT?>:<select size="1" name="jresult">
<?php if (isset($_GET['jresult'])) $jresult_get=intval($_GET['jresult']);
else $jresult_get=-1;
if ($jresult_get>=12||$jresult_get<0) $jresult_get=-1;
if ($jresult_get!=-1){
        $sql=$sql."AND `result`='".strval($jresult_get)."' ";
        $str2=$str2."&jresult=".strval($jresult_get);
}
if ($jresult_get==-1) echo "<option value='-1' selected>All</option>";
else echo "<option value='-1'>All</option>";
for ($j=0;$j<12;$j++){
        $i=($j+4)%12;
        if ($i==$jresult_get) echo "<option value='".strval($jresult_get)."' selected>".$judge_result[$i]."</option>";
        else echo "<option value='".strval($i)."'>".$judge_result[$i]."</option>"; 
}
echo "</select>";
?>
</select>

<?php if(isset($_SESSION['administrator'])||isset($_SESSION['source_browser'])){
        if(isset($_GET['showsim']))
                $showsim=intval($_GET['showsim']);
        else
                $showsim=0;
        echo "SIM:
                        <select name=showsim onchange=\"document.getElementById('simform').submit();\">
                        <option value=0 ".($showsim==0?'selected':'').">All</option>
                        <option value=50 ".($showsim==50?'selected':'').">50</option>
                        <option value=60 ".($showsim==60?'selected':'').">60</option>
                        <option value=70 ".($showsim==70?'selected':'').">70</option>
                        <option value=80 ".($showsim==80?'selected':'').">80</option>
                        <option value=90 ".($showsim==90?'selected':'').">90</option>
                        <option value=100 ".($showsim==100?'selected':'').">100</option>
                  </select>";
/*      if (isset($_GET['cid'])) 
                echo "<input type=hidden name=cid value='".$_GET['cid']."'>";
        if (isset($_GET['language'])) 
                echo "<input type=hidden name=language value='".$_GET['language']."'>";
        if (isset($_GET['user_id'])) 
                echo "<input type=hidden name=user_id value='".$_GET['user_id']."'>";
        if (isset($_GET['problem_id'])) 
                echo "<input type=hidden name=problem_id value='".$_GET['problem_id']."'>";
        //echo "<input type=submit>";
*/
}
echo "<input type=submit value='$MSG_SEARCH'></form>";
?>
</div>
<div id=center>
<table id=result-tab class=content-box-header align=center width=80%>
<tr  class='toprow'>
<th ><?php echo $MSG_RUNID?>
<th ><?php echo $MSG_USER?>
						<th>
							<?php echo $MSG_NICK?>
						</th>
<th ><?php echo $MSG_PROBLEM?>
<th ><?php echo $MSG_RESULT?>
<th ><?php echo $MSG_MEMORY?>
<th ><?php echo $MSG_TIME?>
<th ><?php echo $MSG_LANG?>
<th ><?php echo $MSG_CODE_LENGTH?>
<th ><?php echo $MSG_SUBMIT_TIME?>
<?php	if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
<th class="text-center">
	<?php echo $MSG_JUDGER?>
</th>
<?php   } ?>
</tr>
<tbody>
<?php
function fix($str,$OJ_TEMPLATE){
	require("include/setlang.php");
	if(strstr($str,"AC"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/green.png>".$str;
	if(strstr($str,"WA"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/recent.png>".$str;
	if(strstr($str,"Waiting"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/problemset.png>".$str;
	if(strstr($str,"TE"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/time.png>".$str;
	if(strstr($str,"ME"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/bbs.png>".$str;
	if(strstr($str,"PE"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/pe.png>".$str;
	if(strstr($str,"CE"))
	  return "<img width=23 src=template/".$OJ_TEMPLATE."/image/ce.png>".$str;
	return $str;
}$cnt=0;
foreach($view_status as $row){
  if ($cnt) echo "<tr class='oddrow'>";
  else	echo "<tr class='evenrow'>";
  $i=0;
  foreach($row as $table_cell){
    echo "<td ".($i==3?"bgcolor='#6b88ff' class=toprow":"").">";
					echo "\t".fix($table_cell,$OJ_TEMPLATE);
					echo "</td>";
					$i++;
				}
				echo "</tr>";
				$cnt=1-$cnt;
			}
			?>
			</tbody>
</table>

</div>
<div id=center>
<?php echo "[<a href=status.php?".$str2.">Top</a>]&nbsp;&nbsp;";
if (isset($_GET['prevtop']))
        echo "[<a href=status.php?".$str2."&top=".$_GET['prevtop'].">Previous Page</a>]&nbsp;&nbsp;";
else
        echo "[<a href=status.php?".$str2."&top=".($top+20).">Previous Page</a>]&nbsp;&nbsp;";
echo "[<a href=status.php?".$str2."&top=".$bottom."&prevtop=$top>Next Page</a>]";
?>
</div>



<div id=foot>
	<?php require_once("oj-footer.php");?>

</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
<script>
	var i = 0;
	var judge_result = [<?php
	foreach ($judge_result as $result) {
		echo "'$result',";
	} ?>
	''];

	var judge_color = [<?php
	foreach ($judge_color as $result) {
		echo "'$result',";
	} ?>
	''];
</script>
<script src="<?php echo $OJ_CDN_URL?>template/bs3/jquery.min.js"></script>
<script src="<?php echo $OJ_CDN_URL?>template/bs3/auto_refresh.js"></script>
</body>
</html>
