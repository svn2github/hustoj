<?php
	require_once("oj-header.php");
	echo "<title>HUST Online Judge WebBoard</title>";
	$tid=intval($_REQUEST['tid']);
        if(isset($_GET['cid']))$cid=intval($_GET['cid']);	
	$sql="SELECT t.`title`, `cid`, `pid`, `status`, `top_level` FROM `topic` t left join contest_problem cp on cp.problem_id=t.pid   WHERE `tid` = ? AND `status` <= 1";
//	echo $sql;
	//exit();
	$result=pdo_query($sql,$tid) ;
	$rows_cnt = count($result) ;
	$row= $result[0];
	if($row['cid']>0) $cid=$row['cid'];
	if($row['pid']>0 && $row['cid'] >0 ) {
		$pid=pdo_query("select num from contest_problem where problem_id=? and contest_id=?",$row['pid'],$row['cid'])[0][0];
		$pid=$PID[$pid];
	}else{
		$pid=$row['pid'];
	}
	$isadmin = isset($_SESSION[$OJ_NAME.'_'.'administrator']);
?>

<center>
<div style="width:90%; margin:0 auto; text-align:left;"> 
<div style="text-align:left;font-size:80%;float:left;">[ <a href="newpost.php<?php if ($cid) echo "?cid=$cid&pid=".$row['pid']; ?>">New Thread</a> ]</div>
<?php if ($isadmin){
	?><div style="font-size:80%; float:right"> Change sticky level to<?php $adminurl = "threadadmin.php?target=thread&tid={$tid}&action=";
	if ($row['top_level'] == 0) echo "[ <a href=\"{$adminurl}sticky&level=3\">Level Top</a> ] [ <a href=\"{$adminurl}sticky&level=2\">Level Mid</a> ] [ <a href=\"{$adminurl}sticky&level=1\">Level Low</a> ]"; else echo "[ <a href=\"{$adminurl}sticky&level=0\">Standard</a> ]";
	?> | <?php if ($row['status'] != 1) echo (" [ <a  href=\"{$adminurl}lock\">Lock</a> ]"); else echo(" [ <a href=\"{$adminurl}resume\">Resume</a> ]");
	?> | <?php echo (" [ <a href=\"{$adminurl}delete\">Delete</a> ]");
	?></div><?php }
?>
<table style="width:100%; clear:both">
<tr align=center class='toprow'>
	<td style="text-align:left">
	<a href="discuss.php<?php if ($row['pid']!=0 && $row['cid']!=null) echo "?pid=".$row['pid']."&cid=".$row['cid'];
	else if ($row['pid']!=0) echo"?pid=".$row['pid']; else if ($row['cid']!=null) echo"?cid=".$row['cid'];?>">
	<?php if ($row['pid']!=0) echo "Problem $pid"; else echo "MainBoard";?></a> >> <?php echo nl2br(htmlentities($row['title'],ENT_QUOTES,"UTF-8"));?></td>
</tr>

<?php
	$sql="SELECT `rid`, `author_id`, `time`, `content`, `status` FROM `reply` WHERE `topic_id` = ? AND `status` <=1 ORDER BY `rid` LIMIT 30";
	$result=pdo_query($sql,$tid) ;
	$rows_cnt = count($result);
	$cnt=0;
$i=0;
	foreach ($result as $row){
		$url = "threadadmin.php?target=reply&rid=".$row['rid']."&tid={$tid}&action=";
		if(isset($_SESSION[$OJ_NAME.'_'.'user_id'])) $isuser = strtolower($row['author_id'])==strtolower($_SESSION[$OJ_NAME.'_'.'user_id']);
		else $isuser=false;
?>
<tr align=center class='<?php echo ($cnt=!$cnt)?'even':'odd';?>row'>
	<td>
		
     <div style="display:inline;text-align:left; float:left; margin:0 10px"><a href="../userinfo.php?user=<?php echo $row['author_id']?>"><?php echo $row['author_id']; ?> </a> @ <?php echo $row['time']; ?></div>
		<div class="mon" style="display:inline;text-align:right; float:right">
			<?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])) {?>  
			<span>[ <a href="
				<?php if ($row['status']==0) echo $url."disable\">Disable";
				else echo $url."resume\">Resume";
				?> </a> ]</span>
			<span>[ <a onclick="reply(<?php echo $row['rid'];?>);">Reply</a> ]</span> 
			<?php } ?>
			<span>[ <a href="#">Quote</a> ]</span>
			<span>[ <a href="#">Edit</a> ]</span>
			<span>[ <a 
			<?php if ($isuser || $isadmin) echo "href=".$url."delete";
			?>
			>Delete</a> ]</span>
			<span style="width:5em;text-align:right;display:inline-block;font-weight:bold;margin:0 10px">
			<?php echo $i+1;?>#</span>
		</div>
		<div id="post<?php echo $row['rid'];?>" class=content style="text-align:left; clear:both; margin:10px 30px">
			<?php	if ($row['status'] == 0) echo nl2br(htmlentities($row['content'],ENT_QUOTES,"UTF-8"));
					else {
						if (!$isuser || $isadmin)echo "<div style=\"border-left:10px solid gray\"><font color=red><i>Notice : <br>This reply is blocked by administrator.</i></font></div>";
						if ($isuser || $isadmin) echo nl2br(htmlentities($row['content'],ENT_QUOTES,"UTF-8"));
					}
			?>
		</div>
		<div style="text-align:left; clear:both; margin:10px 30px; font-weight:bold; color:red"></div>
	</td>
</tr>
<?php
$i++;
	}
?>
</table>
<div style="font-size:90%; width:100%; text-align:center">[<a href="#">Top</a>]  [<a href="#">Previous Page</a>]  [<a href="#">Next Page</a>] </div>
<?php if (isset($_SESSION[$OJ_NAME.'_'.'user_id'])){?>
<div style="font-size:80%;"><div style="margin:0 10px">New Reply:</div></div>
<form action="post.php?action=reply" method=post>
<input type=hidden name=tid value=<?php echo $tid;?>>
<div><textarea id="replyContent" name=content style="border:1px dashed #8080FF; width:700px; height:200px; font-size:75%;margin:0 10px; padding:10px"></textarea></div>
<div><input type="submit" style="margin:5px 10px" value="Submit"></input></div>
</form>
<?php }
?>

</center>
</div>
<script>
function reply(rid){
   var origin=$("#post"+rid).text();
   console.log(origin);
   origin="Reply to :"+origin+"\n----------------------\n";
   $("#replyContent").text(origin);
   $("#replyContent").focus();
}
</script>

<?php require_once("../template/$OJ_TEMPLATE/discuss.php")?>
