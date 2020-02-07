<style id="sdaf"></style>
  <script>
                       function changeColor(){
        var color="#f00|#0f0|#00f|#880|#808|#088|yellow|#4CAF50|blue|gray|red|pink";
        color=color.split("|");
        document.getElementById("sdaf").innerHTML=".colorful{transition:all 0.5s;color:"+color[parseInt(Math.random() * color.length)]+'}';
    }
    setInterval("changeColor()",400);     </script>
<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <li class="label">Main</li>
                <li><a href="/status.php"><i class="ti-back-left"></i> 返回前台 </a>
                </li>
                <?php if ($mod=='administrator') { ?>
                <li<?php if ($url=='index.php') echo ' class="active"';?>><a href="./index.php"><i class="ti-home"></i> 后台主页</a>
                </li>
                <li class="label">Normal</li>
                <li<?php if ($url=='setmsg.php') echo ' class="active"';?>><a href="./setmsg.php"><i class="ti-pencil-alt"></i> 设置公告 </a>
                </li>
                <li<?php if ($url=='news_list.php'||$url=='news_edit.php') echo ' class="active"';?>><a href="./news_list.php"><i class="ti-list"></i> 新闻列表</a>
                </li>
                <li<?php if ($url=='news_add_page.php') echo ' class="active"';?>><a href="./news_add_page.php"><i class="ti-plus"></i> 添加新闻</a>
                </li>
                <?php } ?>
                <?php if ($mod=='problem_editor' || $mod=='administrator') { ?>
                <li class="label">Problem</li>
                <li<?php if ($url=='problem_list.php' || $url=="problem_edit.php") echo ' class="active"';?>><a href="./problem_list.php"><i class="ti-list"></i> 问题列表</a></li>
                <li<?php if ($url=='problem_add_page.php') echo ' class="active"';?>><a href="./problem_add_page.php"><i class="ti-plus"></i> 新建问题</a></li>
                <li<?php if ($url=='problem_import.php') echo ' class="active"';?>><a href="./problem_import.php"><i class="ti-import"></i> 导入问题</a></li>
                <li<?php if ($url=='problem_export.php') echo ' class="active"';?>><a href="./problem_export.php"><i class="ti-export"></i> 导出问题</a></li>
                <li<?php if ($url=='problem_rejudge.php') echo ' class="active"';?>><a href="./problem_rejudge.php"><i class="ti-loop"></i> 重判问题</a></li>
                <!--li><a href="./problem_copy.php"><i class="fa fa-copy"></i> 复制问题</a></li-->
                <!--li><a href="./problem_reorder.php"><i class="fa fa-undo"></i> 重新编号</a></li-->
                <?php } ?>
                <?php if ($mod=='contest_creator' || $mod=='administrator') { ?>
                <li class="label">Contest</li>
                <li<?php if ($url=='contest_list.php' || $url == 'contest_edit.php') echo ' class="active"';?>><a href="./contest_list.php"><i class="ti-list"></i> 竞赛列表</a></li>
                <li<?php if ($url=='contest_add.php') echo ' class="active"';?>><a href="./contest_add.php"><i class="ti-plus"></i> 新建竞赛</a></li>
                <?php } ?>
                <?php if ($mod=='administrator') { ?>
                <li class="label">User</li>
                <li<?php if ($url=='user_edit.php' || $url == "user_list.php") echo ' class="active"';?>><a href="./user_list.php"><i class="ti-user"></i> 用户列表</a></li>
                <li<?php if ($url=='team_generate.php') echo ' class="active"';?>><a href="./team_generate.php"><i class="ti-plus"></i> 账号生成</a></li>
                <li<?php if ($url=='privilege_list.php') echo ' class="active"';?>><a href="./privilege_list.php"><i class="ti-list"></i> 权限列表</a></li>
                <li<?php if ($url=='privilege_add.php') echo ' class="active"';?>><a href="./privilege_add.php"><i class="ti-plus"></i> 添加权限</a></li>
                <?php } ?>
                <?php if ($mod=='administrator') { ?>
                <li class="label">Recruitment</li>
                <li<?php if ($url=='rtest_list.php' || $url == "user_list.php") echo ' class="active"';?>><a href="./rtest_list.php"><i class="ti-list"></i> 试题列表</a></li>
                <li<?php if ($url=='sub_status.php' || $url == "user_list.php") echo ' class="active"';?>><a href="./sub_status.php"><i class="ti-info"></i> 提交情况</a></li>
                <?php } ?>
                <?php if ($mod=='administrator') { ?>
                <li class="label">APPLICATION</li>
                <li><a href="/kod"><i class="ti-app">K</i> Kod</a></li>
                <li><a href="/pma"><i class="ti-mysql">P</i> PMA</a></li>
                <?php } ?>
                
            </ul>
        </div>
    </div>
</div>
<!-- /# sidebar -->
<div class="header">
        <div class="pull-left">
            <div class="logo" id="sideLogo">
                <a href="index.php">
                    <img class="full-logo" src="assets/images/logo-big.png" alt="SimDahs">
                    <img class="small-logo" src="assets/images/logo-small.png" alt="SimDahs">
                </a>
            </div>
            <div class="hamburger sidebar-toggle">
                <span class="ti-menu"></span>
            </div>
        </div>

        <div class="pull-right p-r-15">
            <ul>
                <li class="header-icon dib"><img class="avatar-img" src="<?php if ($_SESSION[$OJ_NAME.'_'.'myqq'])  echo "http://q.qlogo.cn/headimg_dl?dst_uin=".$_SESSION[$OJ_NAME.'_'.'myqq']."&spec=160";else echo "../template/meto/logo.jpg";?>" alt="" /> <span class="user-avatar"><?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?> <i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="../userinfo.php?user=<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>"><i class="ti-user"></i> <span>个人信息</span></a></li>
                                <li><a href="../modifypage.php"><i class="ti-pencil-alt"></i> <span>修改信息</span></a></li>
                                <li><a href="../logout.php"><i class="ti-power-off"></i> <span>登出</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>