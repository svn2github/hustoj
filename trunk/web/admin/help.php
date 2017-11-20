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
	<h3><?php echo $MSG_HELP?></h3>
<h4>
<ul>
	<li>
		<a class='btn btn-primary' href="../status.php" target="_top"><b><?php echo $MSG_SEEOJ?></b></a>跳转回到前台
<?php if (isset($_SESSION['administrator'])){
	?>
	<li>
		<a class='btn btn-primary' href="news_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_NEWS?></b></a>添加首页显示的新闻
	<li>
		<a class='btn btn-primary' href="news_list.php" target="main"><b><?php echo $MSG_NEWS.$MSG_LIST?></b></a>管理已经发布的新闻
		
	<li>
	<a class='btn btn-primary' href="user_list.php" target="main"><b>用户管理</b></a>对注册用户停用、启用帐号
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<a class='btn btn-primary' href="problem_add_page.php" target="main"><b><?php echo $MSG_ADD.$MSG_PROBLEM?></b></a>手动添加新的题目，多组测试数据在添加后从题目列表TestData按钮进入上传。
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])||isset($_SESSION['problem_editor'])){
?>
	<li>
		<a class='btn btn-primary' href="problem_list.php" target="main"><b><?php echo $MSG_PROBLEM.$MSG_LIST?></b></a>管理已有的题目和数据，上传数据可以用zip压缩不含目录的数据。
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>		
<li>
	<a class='btn btn-primary' href="contest_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_CONTEST?></b></a>规划新的比赛，用逗号分隔题号。可以设定私有比赛，用密码或名单限制参与者。
<?php }
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
?>
<li>
	<a class='btn btn-primary' href="contest_list.php" target="main"><b><?php echo $MSG_CONTEST.$MSG_LIST?></b></a>已有的比赛列表，修改时间和公开/私有，尽量不要在开赛后调整题目列表。
<?php }
if (isset($_SESSION['administrator'])){
?>
<li>
	<a class='btn btn-primary' href="team_generate.php" target="main"><b><?php echo $MSG_TEAMGENERATOR?></b></a>批量生成大量比赛帐号、密码，用于来自不同学校的参赛者。小系统不要随便使用，可能产生垃圾帐号，无法删除。
<li>
	<a class='btn btn-primary' href="setmsg.php" target="main"><b><?php echo $MSG_SETMESSAGE?></b></a>
设置滚动公告内容<?php }
if (isset($_SESSION['administrator'])||isset( $_SESSION['password_setter'] )){
?><li>
	<a class='btn btn-primary' href="changepass.php" target="main"><b><?php echo $MSG_SETPASSWORD?></b></a>重设指定用户的密码，对于管理员帐号需要先降级为普通用户才能修改。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="rejudge.php" target="main"><b><?php echo $MSG_REJUDGE?></b></a>重判指定的题目、提交或比赛。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="privilege_add.php" target="main"><b><?php echo $MSG_ADD.$MSG_PRIVILEGE?></b></a>给指定用户增加权限，包括管理员、题目添加者、比赛组织者、比赛参加者、代码查看者、手动判题、远程判题等权限。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="privilege_list.php" target="main"><b><?php echo $MSG_PRIVILEGE.$MSG_LIST?></b></a>查看已有的特殊权限列表、进行删除操作。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="source_give.php" target="main"><b><?php echo $MSG_GIVESOURCE?></b></a>将导入系统的标程赠与指定帐号，用于训练后辅助未通过的人学习参考。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="problem_export.php" target="main"><b><?php echo $MSG_EXPORT.$MSG_PROBLEM?></b></a>将系统中的题目以fps.xml文件的形式导出。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="problem_import.php" target="main"><b><?php echo $MSG_IMPORT.$MSG_PROBLEM?></b></a>导入从官方群共享或tk.hustoj.com下载到的fps.xml文件。
<?php }
if (isset($_SESSION['administrator'])){
?><li>
	<a class='btn btn-primary' href="update_db.php" target="main"><b><?php echo $MSG_UPDATE_DATABASE?></b></a>更新数据库结构，在每次升级（sudo update-hustoj）之后应操作一次。
<?php }
if (isset($OJ_ONLINE)&&$OJ_ONLINE){
?><li>
	<a class='btn btn-primary' href="../online.php" target="main"><b><?php echo $MSG_ONLINE?></b></a>查看在线用户
<?php }
?>

<li>
	<a class='btn btn-primary' href="https://github.com/zhblue/hustoj/" target="_blank"><b>HUSTOJ</b></a>开源官网源码下载文档查阅。
<li>
	<a class='btn btn-primary' href="https://github.com/zhblue/freeproblemset/" target="_blank"><b>FreeProblemSet</b></a>FPS文件格式说明
<li>
	<a class='btn btn-primary' href="http://tk.hustoj.com" target="_blank"><b>自助题库</b></a>tk.hustoj.ocm自选题库超市
<li>
	<a class='btn btn-primary' href="http://shang.qq.com/wpa/qunwpa?idkey=d52c3b12ddaffb43420d308d39118fafe5313e271769277a5ac49a6fae63cf7a" target="_blank">手机QQ加官方群23361372</a>加入官方群咨询问题

</ul>
<?php if (isset($_SESSION['administrator'])&&!$OJ_SAE){
?>
	<a href="problem_copy.php" target="main" title="Create your own data"><font color="eeeeee">CopyProblem</font></a> <br>
	<a href="problem_changeid.php" target="main" title="Danger,Use it on your own risk"><font color="eeeeee">ReOrderProblem</font></a>
   
<?php }
?>
<h4>
</body>
</html>
