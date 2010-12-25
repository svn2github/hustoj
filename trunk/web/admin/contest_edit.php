<?session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Add a contest</title>

<?
require_once("../include/db_info.inc.php");
if (isset($_POST['syear']))
{
	$starttime=$_POST['syear']."-".$_POST['smonth']."-".$_POST['sday']." ".$_POST['shour'].":".$_POST['sminute'].":00";
	$endtime=$_POST['eyear']."-".$_POST['emonth']."-".$_POST['eday']." ".$_POST['ehour'].":".$_POST['eminute'].":00";
//	echo $starttime;
//	echo $endtime;
	
	$title=$_POST['title'];
	$private=$_POST['private'];
	
   $lang=$_POST['lang'];
   $langmask=0;
   foreach($lang as $t){
			$langmask+=1<<$t;
	} 
	$langmask=63&(~$langmask);
	echo $langmask;	

	$cid=$_POST['cid'];
	
	$sql="UPDATE `contest` set `title`='$title',`start_time`='$starttime',`end_time`='$endtime',`private`='$private',`langmask`=$langmask WHERE `contest_id`=$cid";
	echo $sql;
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

<form method=POST action='<?=$_SERVER['PHP_SELF']?>'>
<p align=center><font size=4 color=#333399>Edit a Contest</font></p>
<input type=hidden name='cid' value=<?=$cid?>>
<p align=left>Title:<input type=text name=title size=71 value='<?=$title?>'></p>
<p align=left>Start Time:<br>&nbsp;&nbsp;&nbsp;
Year:<input type=text name=syear value=<?=substr($starttime,0,4)?> size=7 >
Month:<input type=text name=smonth value='<?=substr($starttime,5,2)?>' size=7 >
Day:<input type=text name=sday size=7 value='<?=substr($starttime,8,2)?>'>
Hour:<input type=text name=shour size=7 value='<?=substr($starttime,11,2)?>'>;
Minute:<input type=text name=sminute size=7 value=<?=substr($starttime,14,2)?>></p>
<p align=left>End Time:<br>&nbsp;&nbsp;&nbsp;

Year:<input type=text name=eyear value=<?=substr($endtime,0,4)?> size=7 >
Month:<input type=text name=emonth value=<?=substr($endtime,5,2)?> size=7 >
Day:<input type=text name=eday size=7 value=<?=substr($endtime,8,2)?>>&nbsp;
Hour:<input type=text name=ehour size=7 value=<?=substr($endtime,11,2)?>> &nbsp;
Minute:<input type=text name=eminute size=7 value=<?=substr($endtime,14,2)?>></p>

Public/Private:<select name=private>
	<option value=0 <?=$private=='0'?'selected=selected':''?>>Public</option>
	<option value=1 <?=$private=='1'?'selected=selected':''?>>Private</option>
</select>
<br>Problems:<input type=text size=60 name=cproblem value='<?=$plist?>'>
<?
 $lang=(~((int)$langmask))&63;
 $C_select=($lang&1)>0?"selected":"";
 $CPP_select=($lang&2)>0?"selected":"";
 $P_select=($lang&4)>0?"selected":"";
 $J_select=($lang&8)>0?"selected":"";
 $R_select=($lang&16)>0?"selected":"";
 $B_select=($lang&32)>0?"selected":"";
// echo $lang;
?>

 Language:<select name="lang[]" multiple>
		<option value=0 <?=$C_select?>>C</option>
		<option value=1 <?=$CPP_select?>>C++</option>
		<option value=2 <?=$P_select?>>Pascal</option>
		<option value=3 <?=$J_select?>>Java</option>	
		<option value=4 <?=$R_select?>>Ruby</option>	
		<option value=5 <?=$B_select?>>Bash</option>	
	</select>
	

<br>
Users:<textarea name="ulist" rows="10" cols="20"><?php if (isset($ulist)) { echo $ulist; } ?></textarea>
<p><input type=submit value=Submit name=submit><input type=reset value=Reset name=reset></p>

</form>
<?require_once("../oj-footer.php");?>

