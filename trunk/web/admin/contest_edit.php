<?php require("admin-header.php");

if (isset($_POST['syear']))
{
	require_once("../include/check_post_key.php");
	$starttime=intval($_POST['syear'])."-".intval($_POST['smonth'])."-".intval($_POST['sday'])." ".intval($_POST['shour']).":".intval($_POST['sminute']).":00";
	$endtime=intval($_POST['eyear'])."-".intval($_POST['emonth'])."-".intval($_POST['eday'])." ".intval($_POST['ehour']).":".intval($_POST['eminute']).":00";
//	echo $starttime;
//	echo $endtime;
	
	$title=mysql_real_escape_string($_POST['title']);
	$private=mysql_real_escape_string($_POST['private']);
	
   $lang=$_POST['lang'];
   $langmask=0;
   foreach($lang as $t){
			$langmask+=1<<$t;
	} 
	$langmask=1023&(~$langmask);
	echo $langmask;	

	$cid=intval($_POST['cid']);
	
	$sql="UPDATE `contest` set `title`='$title',`start_time`='$starttime',`end_time`='$endtime',`private`='$private',`langmask`=$langmask WHERE `contest_id`=$cid";
	//echo $sql;
	mysql_query($sql) or die(mysql_error());
	$sql="DELETE FROM `contest_problem` WHERE `contest_id`=$cid";
	mysql_query($sql);
	$plist=trim($_POST['cproblem']);
	$pieces = explode(',', $plist);
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `contest_problem`(`contest_id`,`problem_id`,`num`) 
			VALUES ('$cid','$pieces[0]',0)";
		for ($i=1;$i<count($pieces);$i++)
			$sql_1=$sql_1.",('$cid','$pieces[$i]',$i)";
		mysql_query("update solution set num=-1 where contest_id=$cid");
		for ($i=0;$i<count($pieces);$i++){
			$sql_2="update solution set num='$i' where contest_id='$cid' and problem_id='$pieces[$i]';";
			mysql_query($sql_2);
		}
		//echo $sql_1;
		
		mysql_query($sql_1) or die(mysql_error());
		$sql="update `problem` set defunct='N' where `problem_id` in ($plist)";
		mysql_query($sql) or die(mysql_error());
	
	}
	
	$sql="DELETE FROM `privilege` WHERE `rightstr`='c$cid'";
	mysql_query($sql);
	$pieces = explode("\n", trim($_POST['ulist']));
	if (count($pieces)>0 && strlen($pieces[0])>0){
		$sql_1="INSERT INTO `privilege`(`user_id`,`rightstr`) 
			VALUES ('".trim($pieces[0])."','c$cid')";
		for ($i=1;$i<count($pieces);$i++)
			$sql_1=$sql_1.",('".trim($pieces[$i])."','c$cid')";
		//echo $sql_1;
		mysql_query($sql_1) or die(mysql_error());
	}
	
	
	require_once("../oj-footer.php");
	exit();
}else{
	$cid=intval($_GET['cid']);
	$sql="SELECT * FROM `contest` WHERE `contest_id`=$cid";
	$result=mysql_query($sql);
	if (mysql_num_rows($result)!=1){
		mysql_free_result($result);
		echo "No such Contest!";
		exit(0);
	}
	$row=mysql_fetch_assoc($result);
	$starttime=$row['start_time'];
	$endtime=$row['end_time'];
	$private=$row['private'];
	$langmask=$row['langmask'];
	$title=htmlspecialchars($row['title']);
	mysql_free_result($result);
	$plist="";
	$sql="SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=$cid ORDER BY `num`";
	$result=mysql_query($sql) or die(mysql_error());
	for ($i=mysql_num_rows($result);$i>0;$i--){
		$row=mysql_fetch_row($result);
		$plist=$plist.$row[0];
		if ($i>1) $plist=$plist.',';
	}
	$ulist="";
	$sql="SELECT `user_id` FROM `privilege` WHERE `rightstr`='c$cid' order by user_id";
	$result=mysql_query($sql) or die(mysql_error());
	for ($i=mysql_num_rows($result);$i>0;$i--){
		$row=mysql_fetch_row($result);
		$ulist=$ulist.$row[0];
		if ($i>1) $ulist=$ulist."\n";
	}
	
	
}
?>

<form method=POST action='<?php echo $_SERVER['PHP_SELF']?>'>
<?php require_once("../include/set_post_key.php");?>
<p align=center><font size=4 color=#333399>Edit a Contest</font></p>
<input type=hidden name='cid' value=<?php echo $cid?>>
<p align=left>Title:<input type=text name=title size=71 value='<?php echo $title?>'></p>
<p align=left>Start Time:<br>&nbsp;&nbsp;&nbsp;
Year:<input type=text name=syear value=<?php echo substr($starttime,0,4)?> size=7 >
Month:<input type=text name=smonth value='<?php echo substr($starttime,5,2)?>' size=7 >
Day:<input type=text name=sday size=7 value='<?php echo substr($starttime,8,2)?>'>
Hour:<input type=text name=shour size=7 value='<?php echo substr($starttime,11,2)?>'>;
Minute:<input type=text name=sminute size=7 value=<?php echo substr($starttime,14,2)?>></p>
<p align=left>End Time:<br>&nbsp;&nbsp;&nbsp;

Year:<input type=text name=eyear value=<?php echo substr($endtime,0,4)?> size=7 >
Month:<input type=text name=emonth value=<?php echo substr($endtime,5,2)?> size=7 >
Day:<input type=text name=eday size=7 value=<?php echo substr($endtime,8,2)?>>&nbsp;
Hour:<input type=text name=ehour size=7 value=<?php echo substr($endtime,11,2)?>> &nbsp;
Minute:<input type=text name=eminute size=7 value=<?php echo substr($endtime,14,2)?>></p>

Public/Private:<select name=private>
	<option value=0 <?php echo $private=='0'?'selected=selected':''?>>Public</option>
	<option value=1 <?php echo $private=='1'?'selected=selected':''?>>Private</option>
</select>
<br>Problems:<input type=text size=60 name=cproblem value='<?php echo $plist?>'>
<?php $lang=(~((int)$langmask))&1023;
 $C_select=($lang&1)>0?"selected":"";
 $CPP_select=($lang&2)>0?"selected":"";
 $P_select=($lang&4)>0?"selected":"";
 $J_select=($lang&8)>0?"selected":"";
 $R_select=($lang&16)>0?"selected":"";
 $B_select=($lang&32)>0?"selected":"";
 $Y_select=($lang&64)>0?"selected":"";
$P_select=($lang&128)>0?"selected":"";
$L_select=($lang&256)>0?"selected":"";
$S_select=($lang&512)>0?"selected":"";
// echo $lang;
?>

 Language:<select name="lang[]" multiple>
		<option value=0 <?php echo $C_select?>>C</option>
		<option value=1 <?php echo $CPP_select?>>C++</option>
		<option value=2 <?php echo $P_select?>>Pascal</option>
		<option value=3 <?php echo $J_select?>>Java</option>	
		<option value=4 <?php echo $R_select?>>Ruby</option>	
		<option value=5 <?php echo $B_select?>>Bash</option>	
	    <option value=6 <?php echo $Y_select?>>Python</option>	
		<option value=7 <?php echo $P_select?>>PHP</option>	
		<option value=8 <?php echo $L_select?>>Perl</option>	
		<option value=9 <?php echo $S_select?>>C#</option>	
	</select>
	

<br>
Users:<textarea name="ulist" rows="10" cols="20"><?php if (isset($ulist)) { echo $ulist; } ?></textarea>
<p><input type=submit value=Submit name=submit><input type=reset value=Reset name=reset></p>

</form>
<?php require_once("../oj-footer.php");?>

