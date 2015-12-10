<?php 
	require('../include/db_info.inc.php');

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet href='../template/<?php echo $OJ_TEMPLATE?>/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
<?php function checkcontest($MSG_CONTEST){
		require_once("../include/db_info.inc.php");
		$sql="SELECT count(*) FROM `contest` WHERE `end_time`>NOW() AND `defunct`='N'";
		$result=mysqli_query($mysqli,$sql);
		$row=mysqli_fetch_row($result);
		if (intval($row[0])==0) $retmsg=$MSG_CONTEST;
		else $retmsg=$row[0]."<font color=red>&nbsp;$MSG_CONTEST</font>";
		mysqli_free_result($result);
		return $retmsg;
	}
	function checkmail(){
		require_once("../include/db_info.inc.php");
		$sql="SELECT count(1) FROM `mail` WHERE 
				new_mail=1 AND `to_user`='".$_SESSION['user_id']."'";
		$result=mysqli_query($mysqli,$sql);
		if(!$result) return false;
		$row=mysqli_fetch_row($result);
		$retmsg="<font color=red>(".$row[0].")</font>";
		mysqli_free_result($result);
		return $retmsg;
	}
	
	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
		if(file_exists("../faqs.$OJ_LANG.php")){
			$OJ_FAQ_LINK="faqs.$OJ_LANG.php";
		}
	}else{
		require_once("../lang/en.php");
	}
	

	if($OJ_ONLINE){
		require_once('../include/online.php');
		$on = new online();
	}
?>
</head>
<body>
<div id="wrapper">
<div id=head>
<h2><img id=logo src=../image/logo.png><font color="red"> <?php echo $OJ_NAME?> </font></h2>
</div><!--end head-->
<div id=subhead> 
<div id=menu class=navbar>
	  <?php $ACTIVE="btn-warning";?>
  <a  class='btn'  href="../<?php echo $OJ_HOME?>"><i class="icon-home"></i>
		<?php echo $MSG_HOME?>						
		</a>
		
		<a  class='btn <?php if ($url==$OJ_BBS.".php") echo " $ACTIVE";?>'  href="../bbs.php">
		<i class="icon-comment"></i><?php echo $MSG_BBS?></a>
		<a  class='btn <?php if ($url=="problemset.php") echo " $ACTIVE";?>' href="../problemset.php">
		<i class="icon-question-sign"></i><?php echo $MSG_PROBLEMS?></a>
		
		<a  class='btn <?php if ($url=="submitpage.php") echo " $ACTIVE";?>' href="../submitpage.php">
		<i class="icon-pencil"></i><?php echo "编辑器"?></a>
		
		<a  class='btn <?php if ($url=="status.php") echo "  $ACTIVE";?>' href="../status.php">
		<i class="icon-check"></i><?php echo $MSG_STATUS?></a>
		
		<a class='btn <?php if ($url=="ranklist.php") echo "  $ACTIVE";?>' href="../ranklist.php">
		<i class="icon-signal"></i><?php echo $MSG_RANKLIST?></a>
		
		<a class='btn <?php if ($url=="contest.php") echo "  $ACTIVE";?>'  href="../contest.php">
		<i class="icon-fire"></i><?php echo checkcontest($MSG_CONTEST)?></a>
		
		<a class='btn <?php if ($url=="recent-contest.php") echo " $ACTIVE";?>' href="../recent-contest.php">
		<i class="icon-share"></i><?php echo "$MSG_RECENT_CONTEST"?></a>
		
		<a class='btn <?php if ($url==(isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php")) echo " $ACTIVE";?>' href="../<?php echo isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>">
                <i class="icon-info-sign"></i><?php echo "$MSG_FAQ"?></a>
		
		<?php if(isset($OJ_DICT)&&$OJ_DICT&&$OJ_LANG=="cn"){?>
					  
		<span div class='btn '  style="color:1a5cc8" id="dict_status"></span>
					 
  <script src="../include/underlineTranslation.js" type="text/javascript"></script>
					  <script type="text/javascript">dictInit();</script>
		<?php }?>
	</div><!--end menu-->
<div id=profile >

<?php if (isset($_SESSION['user_id'])){
				$sid=$_SESSION['user_id'];
				print "&nbsp;<a href=../modifypage.php>$MSG_USERINFO
					</a><a href='../userinfo.php?user=$sid'>
				<font color=red>$sid</font></a>";
				$mail=checkmail();
				if ($mail)
					print "<a href=../mail.php>$mail</a>";
				print "<a href=../logout.php>$MSG_LOGOUT</a>";
			}else{
				print "<a href=../loginpage.php>$MSG_LOGIN</a>";
				print "<a href=../registerpage.php>$MSG_REGISTER</a>";
			}
			if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
				print "<a href=../admin>$MSG_ADMIN</a>";
			
			}
		?>


</div><!--end profile-->
</div><!--end subhead-->
<div id=broadcast>
<?php echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250>";
	echo "<font color=red>";
	echo file_get_contents($OJ_SAE?"saestor://web/msg.txt":"../admin/msg.txt");
	echo "</font>";
	echo "</marquee>";


?>
</div><!--end broadcast-->
 
<div id=main>
