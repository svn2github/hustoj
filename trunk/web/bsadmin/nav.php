<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <li class="label">Main</li>
                <li><a href="/status.php"><i class="ti-back-left"></i><?php echo $MSG_SEEOJ;?></a>
                </li>
                <?php if ($mod=='administrator') { ?>
                <li<?php if ($url=='index.php') echo ' class="active"';?>><a href="./index.php"><i class="ti-home"></i><?php echo $MSG_ADMIN.$MSG_HOME;?></a>
                </li>
                <li class="label">Normal</li>
                <li<?php if ($url=='setmsg.php') echo ' class="active"';?>><a href="./setmsg.php"><i class="ti-pencil-alt"></i><?php echo $MSG_SETMESSAGE?> </a>
                </li>
                <li<?php if ($url=='news_list.php'||$url=='news_edit.php') echo ' class="active"';?>><a href="./news_list.php"><i class="ti-list"></i><?php echo $MSG_NEWS.$MSG_LIST?></a>
                </li>
                <li<?php if ($url=='news_add_page.php') echo ' class="active"';?>><a href="./news_add_page.php"><i class="ti-plus"></i><?php echo $MSG_ADD.$MSG_NEWS?></a>
                </li>
                <?php } ?>
                <?php if ($mod=='problem_editor' || $mod=='administrator') { ?>
                <li class="label"><?php echo $MSG_PROBLEM;?></li>
                <li<?php if ($url=='problem_list.php' || $url=="problem_edit.php") echo ' class="active"';?>><a href="./problem_list.php"><i class="ti-list"></i><?php echo $MSG_PROBLEM.$MSG_LIST?></a></li>
                <li<?php if ($url=='problem_add_page.php') echo ' class="active"';?>><a href="./problem_add_page.php"><i class="ti-plus"></i><?php echo $MSG_ADD.$MSG_PROBLEM?></a></li>
                <li<?php if ($url=='problem_import.php') echo ' class="active"';?>><a href="./problem_import.php"><i class="ti-import"></i><?php echo $MSG_IMPORT.$MSG_PROBLEM?></a></li>
                <li<?php if ($url=='problem_export.php') echo ' class="active"';?>><a href="./problem_export.php"><i class="ti-export"></i><?php echo $MSG_EXPORT.$MSG_PROBLEM?></a></li>
                <li<?php if ($url=='problem_rejudge.php') echo ' class="active"';?>><a href="./problem_rejudge.php"><i class="ti-loop"></i><?php echo $MSG_REJUDGE?></a></li>
                <!--li><a href="./problem_copy.php"><i class="fa fa-copy"></i> 复制问题</a></li-->
                <!--li><a href="./problem_reorder.php"><i class="fa fa-undo"></i> 重新编号</a></li-->
                <?php } ?>
                <?php if ($mod=='contest_creator' || $mod=='administrator') { ?>
                <li class="label"><?php echo $MSG_CONTEST;?></li>
                <li<?php if ($url=='contest_list.php' || $url == 'contest_edit.php') echo ' class="active"';?>><a href="./contest_list.php"><i class="ti-list"></i><?php echo $MSG_CONTEST.$MSG_LIST?></a></li>
                <li<?php if ($url=='contest_add.php') echo ' class="active"';?>><a href="./contest_add.php"><i class="ti-plus"></i><?php echo $MSG_ADD.$MSG_CONTEST?></a></li>
                <?php } ?>
                <?php if ($mod=='administrator') { ?>
                <li class="label"><?php echo $MSG_USER;?></li>
                <li<?php if ($url=='user_edit.php' || $url == "user_list.php") echo ' class="active"';?>><a href="./user_list.php"><i class="ti-user"></i><?php echo $MSG_USER.$MSG_LIST?></a></li>
                <li<?php if ($url=='team_generate.php') echo ' class="active"';?>><a href="./team_generate.php"><i class="ti-plus"></i><?php echo $MSG_TEAMGENERATOR?></a></li>
                <li<?php if ($url=='privilege_list.php') echo ' class="active"';?>><a href="./privilege_list.php"><i class="ti-list"></i><?php echo $MSG_PRIVILEGE.$MSG_LIST?></a></li>
                <li<?php if ($url=='privilege_add.php') echo ' class="active"';?>><a href="./privilege_add.php"><i class="ti-plus"></i><?php echo $MSG_ADD.$MSG_PRIVILEGE?></a></li>
                <?php } ?>
                <?php if ($mod=='administrator') { ?>
                <li class="label"><?php echo $MSG_SYSTEM;?></li>
                <li<?php if ($url=='update_db.php') echo ' class="active"';?>><a href="./update_db.php"><i class="ti-dropbox"></i><?php echo $MSG_UPDATE_DATABASE?></a></li>
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
                <li class="header-icon dib"><img class="avatar-img" src="http://q.qlogo.cn/headimg_dl?dst_uin=1440169768&spec=160" alt="" /> <span class="user-avatar"><?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?> <i class="ti-angle-down f-s-10"></i></span>
                    <div class="drop-down dropdown-profile">
                        <div class="dropdown-content-body">
                            <ul>
                                <li><a href="../userinfo.php?user=<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>"><i class="ti-user"></i> <span><?php echo $MSG_USERINFO;?></span></a></li>
                                <li><a href="../modifypage.php"><i class="ti-pencil-alt"></i> <span><?php echo $MSG_REG_INFO;?></span></a></li>
                                <li><a href="../logout.php"><i class="ti-power-off"></i> <span><?php echo $MSG_LOGOUT;?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
