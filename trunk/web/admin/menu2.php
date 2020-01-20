<?php require_once("admin-header.php");

	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
	}
	$path_fix="../";

?>
<html>
<head>
<title><?php echo $MSG_ADMIN?></title>
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>bootstrap-theme.min.css">
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>bootstrap.min.js"></script>

</head>

<body>
<h4>

  <a class='btn' href="../status.php" target="_top" title="<?php echo $MSG_HELP_SEEOJ?>"><b><?php echo $MSG_SEEOJ?></b></a><br>
<?php 
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){?>
<div class="btn-group">
	<button type="button" class="btn dropdown-toggle" 
			data-toggle="dropdown">
		<?php echo $MSG_PROBLEM.$MSG_ADMIN ?><span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
  <li><a href="problem_list.php" target="main" title="<?php echo $MSG_HELP_PROBLEM_LIST?>"><b><?php echo $MSG_PROBLEM.$MSG_LIST?></b></a>
  <?php }
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){?>
  <li><a class='btn' href="problem_add_page.php" target="main" title="<?php echo html_entity_decode($MSG_HELP_ADD_PROBLEM)?>"><b><?php echo $MSG_ADD.$MSG_PROBLEM?></b></a>
  <?php }
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
  <li><a class='btn g' href="rejudge.php" target="main" title="<?php echo $MSG_HELP_REJUDGE?>"><b><?php echo $MSG_REJUDGE?></b></a>
  <li><a class='btn' href="problem_import.php" target="main" title="<?php echo $MSG_HELP_IMPORT_PROBLEM?>"><b><?php echo $MSG_IMPORT.$MSG_PROBLEM?></b></a>
  <li><a class='btn' href="problem_export.php" target="main" title="<?php echo $MSG_HELP_EXPORT_PROBLEM?>"><b><?php echo $MSG_EXPORT.$MSG_PROBLEM?></b></a>
  <?php }?>
	</ul>
</div><br>
  <?php 
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])){?>
<div class="btn-group">
	<button type="button" class="btn dropdown-toggle" 
			data-toggle="dropdown">
		<?php echo $MSG_CONTEST ?><span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
  <li><a class='btn ' href="contest_list.php" target="main"  title="<?php echo $MSG_HELP_CONTEST_LIST?>"><b><?php echo $MSG_CONTEST.$MSG_LIST?></b></a>
  <li><a class='btn ' href="contest_add.php" target="main"  title="<?php echo $MSG_HELP_ADD_CONTEST?>"><b><?php echo $MSG_ADD.$MSG_CONTEST?></b></a>
  <?php }
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
  <li><a class='btn ' href="team_generate.php" target="main" title="<?php echo $MSG_HELP_TEAMGENERATOR?>"><b><?php echo $MSG_TEAMGENERATOR?></b></a>
  <li><a class='btn ' href="team_generate2.php" target="main" title="<?php echo $MSG_HELP_TEAMGENERATOR?>"><b><?php echo $MSG_TEAMGENERATOR?></b></a>	  
</div><br>
  <?php } ?>
<?php
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
<div class="btn-group">
	<button type="button" class="btn dropdown-toggle" 
			data-toggle="dropdown">
		<?php echo $MSG_NEWS.$MSG_ADMIN ?><span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
  <li><a class='btn g' href="setmsg.php" target="main" title="<?php echo $MSG_HELP_SETMESSAGE?>"><b><?php echo $MSG_SETMESSAGE?></b></a>
  <li><a class='btn g' href="news_list.php" target="main" title="<?php echo $MSG_HELP_NEWS_LIST?>"><b><?php echo $MSG_NEWS.$MSG_LIST?></b></a>
  <li><a class='btn g' href="news_add_page.php" target="main" title="<?php echo $MSG_HELP_ADD_NEWS?>"><b><?php echo $MSG_ADD.$MSG_NEWS?></b></a>
	</ul>
</div><br>
  <?php }?>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
  <div class="btn-group">
	<button type="button" class="btn dropdown-toggle" 
			data-toggle="dropdown">
		<?php echo $MSG_USER.$MSG_ADMIN ?><span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
  <li><a class='btn g' href="user_list.php" target="main" title="<?php echo $MSG_HELP_USER_LIST?>"><b><?php echo $MSG_USER.$MSG_LIST?></b></a>
  <li><a class='btn g' href="user_set_ip.php" target="main" title="<?php echo $MSG_SET_LOGIN_IP?>"><b><?php echo $MSG_SET_LOGIN_IP?></b></a>
  <?php }
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset( $_SESSION[$OJ_NAME.'_'.'password_setter'] )){?>
  <li><a class='btn g' href="changepass.php" target="main" title="<?php echo $MSG_HELP_SETPASSWORD?>"><b><?php echo $MSG_SETPASSWORD?></b></a></li>
</ul></div><br>
  <?php }
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
<div class="btn-group">
	<button type="button" class="btn dropdown-toggle" 
			data-toggle="dropdown">
		<?php echo $MSG_SYSTEM.$MSG_ADMIN ?><span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
  <li><a class='btn ' href="source_give.php" target="main" title="<?php echo $MSG_HELP_GIVESOURCE?>"><b><?php echo $MSG_GIVESOURCE?></b></a>
  <li><a class='btn ' href="privilege_list.php" target="main" title="<?php echo $MSG_HELP_PRIVILEGE_LIST?>"><b><?php echo $MSG_PRIVILEGE.$MSG_LIST?></b></a>
  <li><a class='btn ' href="privilege_add.php" target="main" title="<?php echo $MSG_HELP_ADD_PRIVILEGE?>"><b><?php echo $MSG_ADD.$MSG_PRIVILEGE?></b></a>
  <?php } ?>
  <?php
  if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
  <li><a class='btn ' href="update_db.php" target="main" title="<?php echo $MSG_HELP_UPDATE_DATABASE?>"><b><?php echo $MSG_UPDATE_DATABASE?></b></a><br>
  <?php }?>
</ul>
</div><br>
<?php 
  if (isset($OJ_ONLINE)&&$OJ_ONLINE){?>
  <br><a class='btn ' href="../online.php" target="main"><b><?php echo $MSG_ONLINE?></b></a>
  <?php }?>
  <br><a class='btn ' href="https://github.com/zhblue/hustoj/" target="_blank"><b>HUSTOJ</b></a>
  <br><a class='btn ' href="https://github.com/zhblue/freeproblemset/" target="_blank"><b>FreeProblemSet</b></a>
  <br><a class='btn ' href="http://tk.hustoj.com" target="_blank"><b>自助题库</b></a>
  <br><a class='btn ' href="http://shang.qq.com/wpa/qunwpa?idkey=d52c3b12ddaffb43420d308d39118fafe5313e271769277a5ac49a6fae63cf7a" target="_blank">手机QQ加官方<br>群23361372</a>
	
<?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])&&!$OJ_SAE){
?>
	<a href="problem_copy.php" target="main" title="Create your own data"><font color="eeeeee">CopyProblem</font></a> <br>
	<a href="problem_changeid.php" target="main" title="Danger,Use it on your own risk"><font color="eeeeee">ReOrderProblem</font></a>
   
<?php }
?>
</body>
</html>
