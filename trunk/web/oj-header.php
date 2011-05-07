<?php 
	require('./include/db_info.inc.php');

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel=stylesheet href='./include/<?php echo $OJ_CSS?>' type='text/css'>
<?


	
	function checkcontest($MSG_CONTEST){
		require_once("./include/db_info.inc.php");
		$sql="SELECT count(*) FROM `contest` WHERE `end_time`>NOW() AND `defunct`='N'";
		$result=mysql_query($sql);
		$row=mysql_fetch_row($result);
		if (intval($row[0])==0) $retmsg=$MSG_CONTEST;
		else $retmsg=$row[0]."<span class=red>&nbsp;$MSG_CONTEST</span>";
		mysql_free_result($result);
		return $retmsg;
	}
	function checkmail(){
		require_once("./include/db_info.inc.php");
		$sql="SELECT count(1) FROM `mail` WHERE 
				new_mail=1 AND `to_user`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		if(!$result) return false;
		$row=mysql_fetch_row($result);
		$retmsg="<span id=red>(".$row[0].")</span>";
		mysql_free_result($result);
		return $retmsg;
	}
	
	if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
		if(file_exists("./faqs.$OJ_LANG.php")){
			$OJ_FAQ_LINK="./faqs.$OJ_LANG.php";
		}
	}else{
		require_once("./lang/en.php");
	}
	

	if($OJ_ONLINE){
		require_once('./include/online.php');
		$on = new online();
	}
?>
</head>
<body>
<div id=head>
<h2><img id=logo src=./image/logo.png><span id="red">Welcome To <?=$OJ_NAME?> ACM-ICPC Online Judge</span></h2>
</div><!--end head-->
<div id=subhead>
<div id=menu >
		<div class=menu_item >
		<a href="<?=$OJ_HOME?>"><?=$MSG_HOME?></a>
		</div>
		<div class=menu_item >
		<a href="bbs.php"><?=$MSG_BBS?></a>
		</div>
		<div class=menu_item >
		<a href="problemset.php"><?=$MSG_PROBLEMS?></a>
		</div>
		<div class=menu_item >
		<a href="status.php"><?=$MSG_STATUS?></a>
		</div>
		<div class=menu_item >
		<a href="ranklist.php"><?=$MSG_RANKLIST?></a>
		</div>
		<div class=menu_item >
		<a href="contest.php"><?=checkcontest($MSG_CONTEST)?></a>
		</div>
		<div class=menu_item >
		<a href="<?=isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>"><?=$MSG_FAQ?></a>
		</div>
		<?if(isset($OJ_DICT)&&$OJ_DICT&&$OJ_LANG=="cn"){?><div class=menu_item >
		<span style="color:1a5cc8" id="dict_status"></span></div>
		<?}?>
</div><!--end menu-->
<div id=profile >

<?
			
			if (isset($_SESSION['user_id'])){
				$sid=$_SESSION['user_id'];
				print "&nbsp;<a href=./modifypage.php>$MSG_USERINFO
					</a><a href='./userinfo.php?user=$sid'>
				<span id=red>$sid</span></a>";
				$mail=checkmail();
				if ($mail)
					print "<a href=./mail.php>$mail</a>";
				print "<a href=./logout.php>$MSG_LOGOUT</a>";
			}else{
				print "<a href=./loginpage.php>$MSG_LOGIN</a>";
				print "<a href=./registerpage.php>$MSG_REGISTER</a>";
			}
			if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
				print "<a href=./admin>$MSG_ADMIN</a>";
			
			}
		?>


</div><!--end profile-->
</div><!--end subhead-->

<?
	echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>";
	require('./admin/msg.txt');
	echo "</marquee>";

?>

<script src="include/underlineTranslation.js" type="text/javascript"></script> 
<script type="text/javascript">dictInit();</script> 
<div id=main>
