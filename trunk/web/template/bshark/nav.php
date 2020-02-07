<?php 
$cur_path = "template/$OJ_TEMPLATE/";
	$url=basename($_SERVER['REQUEST_URI']);
	$realurl=basename($_SERVER['REQUEST_URI']);
	$url=str_replace(strrchr($url, "?"),"",$url); 
?>
<style id="navbarstyles">
</style>
<ul class="nav_ul" id="navbar" style="margin-left:0">
<li style="margin-left:5%"></li>
<li class="nav-item" id="logolink" style="overflow: hidden;transition: all 0.5s;">
<a class="nav-link" href="/"><b><?php echo $OJ_NAME;?></b></a>
</li>
<li class="nav-item">
<a class="nav-link<?php if ($url=='') echo ' active';?>" href="/">首页</a>
<span class="line <?php if ($url=='') echo ' active';?>"></span>
</li>
<li class="nav-item">
<a class="nav-link<?php if ($url=='problemset.php') echo ' active';?>" href="./problemset.php">题库</a>
<span class="line <?php if ($url=='problemset.php') echo ' active';?>"></span>
</li>
<li class="nav-item">
<a class="nav-link<?php if ($url=='contest.php') echo ' active';?>" href="./contest.php">竞赛</a>
<span class="line<?php if ($url=='contest.php') echo ' active';?>"></span>
</li>
     <li class="nav-item">
<a class="nav-link<?php if ($url=='status.php') echo ' active';?>" href="./status.php">状态</a>
<span class="line<?php if ($url=='status.php') echo ' active';?>"></span>
      </li> 
     <li class="nav-item">
<a class="nav-link<?php if ($url=='ranklist.php') echo ' active';?>" href="./ranklist.php">排名</a>
<span class="line<?php if ($url=='ranklist.php') echo ' active';?>"></span>
      </li> 
      <?php 
        if ($_SESSION[$OJ_NAME.'_'.'user_id']) {
    ?>
      <li class="nav-item dropdown" style="margin-right:7%;float:right">
          <?php $if_new_mail = count(pdo_query('select * from `mail` where `to_user`=? and `new_mail`=1',$_SESSION[$OJ_NAME.'_'.'user_id']))>0?1:0; ?>
      <a class="nav-link dropdown-toggle" href="" id="navbardrop" data-toggle="dropdown"><i class="iconfont icon-user"></i>
        <span style="position:relative" <?php 
                        if ($viplevel[$_SESSION[$OJ_NAME.'_'.'user_id']]) {
                            if ($isadmm[$_SESSION[$OJ_NAME.'_'.'user_id']]==23333) echo ' class="purple-c"';
                            else echo ' class="colorful"';
                        }
                        else if ($isadmm[$_SESSION[$OJ_NAME.'_'.'user_id']]==23333) echo ' class="purple"';
          ?>><?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?></span>
        <span class="line"></span>
      </a>
      <span class="line"></span>
      <div class="dropdown-content animated">
        <div><a class="dropdown-item" href="./userinfo.php?user=<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>">个人信息</a></div>
        <div><a class="dropdown-item" href="./modifypage.php">信息修改</a></div>
        <div><a class="dropdown-item" href="./mail.php" style="position:relative">聊天<?php if ($if_new_mail) { ?>(有新消息)<?php } ?></a></div>
        <div><a class="dropdown-item" href="./logout.php">注销</a></div>
        <?php 
        if ($_SESSION[$OJ_NAME.'_'.'administrator']) {
        ?>
        
        <div><a class="dropdown-item" href="./bsadmin">管理</a></div>
        <?php 
          }
        ?>
      </div>
    </li>
      <?php } else {?>
      <li class="nav-item" style="float:right;margin-right:7%">
        <a class="nav-link" href="./registerpage.php">注册</a>
<span class="line"></span>
      </li> 
      <li class="nav-item" style="float:right;">
        <a class="nav-link" href="./loginpage.php">登陆</a>
<span class="line"></span>
      </li> 
      <?php } ?>
</ul>

<div id=banner style="width:100%;height:200px;margin:0;background-image: url('./template/bshark/1.jpg');
background-position: center center;
background-repeat: no-repeat;
background-attachment: fixed;
background-size: cover;
background-color: #ffffff;position:relative">
    <div style="position:absolute;bottom:10px;margin-left:10%" id="bannerbox">
        <a href="/"><img src="/template/bshark/logo.png" height="120" id="bannerlogo" style="display:inline"></a>
    </div>
</div>
<script>
var tac = 0;
    var ooottt = window.setInterval(function() {
    var pps = window.pageYOffset;
    $('#navbar').mouseover(function(e) {
        tac = 1;
    }).mouseout(function(e) {
        tac = 0;
});
    if (tac == 1) {
        navbar.style.backgroundColor = 'rgba(255,255,255,1)';
        document.getElementById("navbarstyles").innerHTML = ".nav_ul li a{color:#000;}.nav_ul li .line{background:#ed5f82;}";
    } else if (pps > 150) {
        navbar.style.boxShadow = '0px 1px 2px rgba(0,0,0,0.2)';
    navbar.style.backgroundColor = 'rgba(255,255,255,1)';
        document.getElementById("navbarstyles").innerHTML = ".nav_ul li a{color:#000;}.nav_ul li .line{background:#ed5f82;}";
    logolink.style.width = '98px';
    } else {
        navbar.style.boxShadow = '0 0 0 0 rgba(0,0,0,0.5)';
    navbar.style.backgroundColor = 'rgba(255,255,255,0)';
        document.getElementById("navbarstyles").innerHTML = ".nav_ul li a{color:#fff;}.nav_ul li .line{background:#9ae3f3;}";
    logolink.style.width = '0px';
}
}, 200);
</script>
