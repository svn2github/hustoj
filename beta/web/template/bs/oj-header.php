<div id=head>
<h2><img id=logo src="<?php echo "template/".$OJ_TEMPLATE?>/image/logo.png"><span class="red">Welcome To <?php echo $OJ_NAME?> Online Judge</span></h2>
</div><!--end head-->
<div id=subhead>
	  <div id=menu>
	    <div class='btn' >
		<a  href="<?php echo $OJ_HOME?>"><?php if ($url=="JudgeOnline") echo "<span class='_selected'>";?>
								<?php echo $MSG_HOME?>
								<?php if ($url=="JudgeOnline") echo "</span>";?>
		</a>
		</div>
		<div class='btn' >
		<a  href="bbs.php"><?php if ($url==$OJ_BBS.".php") echo "<span class='_selected'>";?>
		<?php echo $MSG_BBS?><?php if ($url==$OJ_BBS.".php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="problemset.php"><?php if ($url=="problemset.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_PROBLEMS?><?php if ($url=="problemset.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="status.php"><?php if ($url=="status.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_STATUS?><?php if ($url=="status.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="ranklist.php"><?php if ($url=="ranklist.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_RANKLIST?><?php if ($url=="ranklist.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="contest.php"><?php if ($url=="contest.php") echo "<span class='_selected'>";?>
		<?php echo checkcontest($MSG_CONTEST)?><?php if ($url=="contest.php") echo "</span>";?></a>
		</div>
        <div class='btn' >
		<a  href="recent-contest.php"><?php if ($url=="recent-contest.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_RECENT_CONTEST?><?php if ($url=="recent-contest.php") echo "</span>";?></a>
		</div>
		<div class='btn' ><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "<span class='_selected'>";?>
		<a  href="<?php echo isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>"><?php echo $MSG_FAQ?><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "</span>";?></a>
		</div>
		<?php if(isset($OJ_DICT)&&$OJ_DICT&&$OJ_LANG=="cn"){?>
					  <div class='btn' >
							  <span  style="color:1a5cc8" id="dict_status"></span>
					  </div>
					  <script src="include/underlineTranslation.js" type="text/javascript"></script>
					  <script type="text/javascript">dictInit();</script>
		<?php }?>
	</div><!--end menu-->
<div id=profile >
<script src="include/profile.php?<?php echo rand();?>" ></script>
</div><!--end profile-->
</div><!--end subhead-->
<div id=broadcast>
<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>
  <?php echo $view_marquee_msg?>
</marquee>
</div>
