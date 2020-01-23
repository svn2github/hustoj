<?php require_once("admin-header.php");
  if(isset($OJ_LANG)){
    require_once("../lang/$OJ_LANG.php");
  }
?>
<html>
<head>
  <title><?php echo $MSG_ADMIN?></title>
</head>

<body>
<table class="table">
  <tbody>
    <tr>
      <td><a class='btn btn-block' href="../status.php" target="_top"><b><?php echo $MSG_SEEOJ?></b></a></td>
      <td><?php echo $MSG_HELP_SEEOJ?></td>
    </tr>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
    <tr>
      <td><center><a class='btn btn-info' href="setmsg.php" target="main"><b><?php echo $MSG_SETMESSAGE?></b></a></center></td>
      <td><?php echo $MSG_HELP_SETMESSAGE?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-info' href="news_list.php" target="main"><b><?php echo $MSG_NEWS.$MSG_LIST?></b></a></center></td>
      <td><?php echo $MSG_HELP_NEWS_LIST?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-info' href="news_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_NEWS?></b></a></center></td>
      <td><?php echo $MSG_HELP_ADD_NEWS?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-primary' href="user_list.php" target="main"><b><?php echo $MSG_USER.$MSG_LIST?></b></a></center></td>
      <td><?php echo $MSG_HELP_USER_LIST?></td>
    </tr>
  <?php }?>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset( $_SESSION[$OJ_NAME.'_'.'password_setter'] )){?>
    <tr>
      <td><center><a class='btn btn-primary' href="changepass.php" target="main"><b><?php echo $MSG_SETPASSWORD?></b></a></center></td>
      <td><?php echo $MSG_HELP_SETPASSWORD?></td>
    </tr>
  <?php }?>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
   <tr>
      <td><center><a class='btn btn-primary' href="user_set_ip.php" target="main"><b><?php echo $MSG_SET_LOGIN_IP?></b></a></center></td>
      <td><?php echo $MSG_SET_LOGIN_IP?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-primary' href="privilege_list.php" target="main"><b><?php echo $MSG_PRIVILEGE.$MSG_LIST?></b></a></center></td>
      <td><?php echo $MSG_HELP_PRIVILEGE_LIST?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-primary' href="privilege_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_PRIVILEGE?></b></a></center></td>
      <td><?php echo $MSG_HELP_ADD_PRIVILEGE?></td>
    </tr>
  <?php }?>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])){?>
    <tr>
      <td><center><a class='btn btn-success' href="problem_list.php" target="main"><b><?php echo $MSG_PROBLEM.$MSG_LIST?></b></a></center></td>
      <td><?php echo $MSG_HELP_PROBLEM_LIST?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-success' href="problem_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_PROBLEM?></b></a></center></td>
      <td><?php echo $MSG_HELP_ADD_PROBLEM?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-success' href="problem_import.php" target="main"><b><?php echo $MSG_IMPORT.$MSG_PROBLEM?></b></a></center></td>
      <td><?php echo $MSG_HELP_IMPORT_PROBLEM?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-success' href="problem_export.php" target="main"><b><?php echo $MSG_EXPORT.$MSG_PROBLEM?></b></a></center></td>
      <td><?php echo $MSG_HELP_EXPORT_PROBLEM?></td>
    </tr>
  <?php }?>
  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])){?>
    <tr>
      <td><center><a class='btn btn-warning' href="contest_list.php" target="main"><b><?php echo $MSG_CONTEST.$MSG_LIST?></b></a></center></td>
      <td><?php echo $MSG_HELP_CONTEST_LIST?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-warning' href="contest_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_CONTEST?></b></a></center></td>
      <td><?php echo $MSG_HELP_ADD_CONTEST?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-warning' href="team_generate.php" target="main"><b><?php echo $MSG_TEAMGENERATOR?></b></a></center></td>
      <td><?php echo $MSG_HELP_TEAMGENERATOR?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-warning' href="team_generate2.php" target="main"><b><?php echo $MSG_TEAMGENERATOR?></b></a></center></td>
      <td><?php echo $MSG_HELP_TEAMGENERATOR?></td>
    </tr>
  <?php }?>

  <?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])){?>
    <tr>
      <td><center><a class='btn btn-danger' href="rejudge.php" target="main"><b><?php echo $MSG_REJUDGE?></b></a></center></td>
      <td><?php echo $MSG_HELP_REJUDGE?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-danger' href="source_give.php" target="main"><b><?php echo $MSG_GIVESOURCE?></b></a></center></td>
      <td><?php echo $MSG_HELP_GIVESOURCE?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-danger' href="../online.php" target="main"><b><?php echo $MSG_HELP_ONLINE?></b></a></center></td>
      <td><?php echo $MSG_HELP_ONLINE?></td>
    </tr>
    <tr>
      <td><center><a class='btn btn-danger' href="update_db.php" target="main"><b><?php echo $MSG_UPDATE_DATABASE?></b></a></center></td>
      <td><?php echo $MSG_HELP_UPDATE_DATABASE?></td>
    </tr>
    <tr>
      <td><a class='btn btn-block' href="https://github.com/zhblue/hustoj/" target="_blank"><b>HUSTOJ</b></a></td>
      <td>HUSTOJ</td>
    </tr>
    <tr>
      <td><center><a class='btn' target='_blank' href="https://github.com/zhblue/hustoj/blob/master/wiki/FAQ.md" target="main"><?php echo $MSG_ADMIN." ".$MSG_FAQ?></a></center></td>
      <td><?php echo $MSG_ADMIN." ".$MSG_FAQ?></td>
    </tr>
    <tr>
      <td><a class='btn btn-block' href="https://github.com/zhblue/freeproblemset/" target="_blank"><b>FreeProblemSet</b></a></td>
      <td>FreeProblemSet</td>
    </tr>
    <tr>
      <td><a class='btn btn-block' href="http://tk.hustoj.com" target="_blank"><b>自助题库</b></a></td>
      <td></td>
    </tr>
    <tr>
      <td><a class='btn btn-block' href="http://shang.qq.com/wpa/qunwpa?idkey=d52c3b12ddaffb43420d308d39118fafe5313e271769277a5ac49a6fae63cf7a" target="_blank">手机QQ加官方群23361372</a></td>
      <td></td>
    </tr>
  <?php }?>
  </tbody>
</table>

<?php if (isset($_SESSION[$OJ_NAME.'_'.'administrator'])&&!$OJ_SAE){?>
  <a href="problem_copy.php" target="main" title="Create your own data"><font color="eeeeee">CopyProblem</font></a> <br>
  <a href="problem_changeid.php" target="main" title="Danger,Use it on your own risk"><font color="eeeeee">ReOrderProblem</font></a>
  
<?php }?>

</body>
</html>
