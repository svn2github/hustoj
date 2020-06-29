<div id=head>
<nobr>
<img height=100 src=<?php echo "template/".$OJ_TEMPLATE?>/image/logo.png>
<img height=100 src=<?php echo "template/".$OJ_TEMPLATE?>/image/banner.jpg>
<img height=100 src=<?php echo "template/".$OJ_TEMPLATE?>/image/logo_r.jpg>
</nobr>
</div><!--end head-->
<div id=subhead>
	  <div id=menu>
	    <div class=menu_item >
		<a href="<?php echo $OJ_HOME?>">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/home.png>
		<?php if ($url=="") echo "<span style='color:orange'>";?>
		<?php echo $MSG_HOME."</span>"?>
		</a>
		</div>
		<div class=menu_item >
		<a href="bbs.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/bbs.png>
		<?php if ($url==$OJ_BBS.".php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_BBS?><?php if ($url==$OJ_BBS.".php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="problemset.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/problemset.png>
		<?php if ($url=="problemset.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_PROBLEMS?><?php if ($url=="problemset.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="status.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/status.png>
		<?php if ($url=="status.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_STATUS?><?php if ($url=="status.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="ranklist.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/rank.png>
		<?php if ($url=="ranklist.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_RANKLIST?><?php if ($url=="ranklist.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<a href="contest.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/contest.png>
		<?php if ($url=="contest.php") echo "<span style='color:orange'>";?>
		<?php echo checkcontest($MSG_CONTEST)?><?php if ($url=="contest.php") echo "</span>";?></a>
		</div>
                <div class=menu_item >
		<a href="recent-contest.php">
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/recent.png>
		<?php if ($url=="recent-contest.php") echo "<span style='color:orange'>";?>
		<?php echo $MSG_RECENT_CONTEST?><?php if ($url=="recent-contest.php") echo "</span>";?></a>
		</div>
		<div class=menu_item >
		<img width=23 src=<?php echo "template/".$OJ_TEMPLATE?>/image/faq.png>
		<?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "<span style='color:orange'>";?>
		<a href="<?php echo isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>"><?php echo $MSG_FAQ?><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "</span>";?></a>
		</div>
		<?php if(isset($OJ_DICT)&&$OJ_DICT){?>
		  <div class=menu_item >
		    <span style="color:1a5cc8" id="dict_status"></span>
		  </div>
		  <script src="include/underlineTranslation.js" type="text/javascript"></script>
		  <script type="text/javascript">dictInit();</script>
		<?php }?>
	</div><!--end menu-->
        <div id=profile>
            <script src="<?php echo 'template/'.$OJ_TEMPLATE?>/swProfile.php" ></script>
        </div><!--end profile-->
</div><!--end subhead-->
</div>
