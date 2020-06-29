<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>修改信息 - <?php echo $OJ_NAME;?></title>
        <?php require( "./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require( "./template/bshark/nav.php");?>
        <?php require_once( './include/set_post_key.php');?>
        <div class="card" style="margin: 3% 8% 5% 8%">
            <div class="card-body">
                 <h4>修改信息</h4>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link<?php if (isset($_GET['pass'])||(!isset($_GET['mail']) && !isset($_GET['info']) && !isset($_GET['theme']))) echo ' active';?>" href="?pass">修改密码</a>

                    </li>
                    <li class="nav-item"> <a class="nav-link <?php if (isset($_GET['mail'])) echo ' active';?>" href="?mail">修改邮箱</a>

                    </li>
                    <li class="nav-item"> <a class="nav-link<?php if (isset($_GET['info'])) echo ' active';?>" href="?info">修改信息</a>

                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane<?php if (isset($_GET['pass'])||(!isset($_GET['mail']) && !isset($_GET['info']) && !isset($_GET['theme']))) echo ' active';?>">
                        <br>
                        <form method="post" action="modify_password.php">
                            <input type="hidden" name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey'];?>">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-user"></i></span>

                                        </div>
                                        <input type="text" class="form-control" id="user_id" value="<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-key"></i></span>

                                        </div>
                                        <input type="password" class="form-control" name="old-password" placeholder="旧密码" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-key"></i></span>

                                        </div>
                                        <input type="password" class="form-control" name="new1-password" placeholder="新密码" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-key"></i></span>

                                        </div>
                                        <input type="password" class="form-control" name="new2-password" placeholder="重复密码" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-outline-info">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="menu1" class="container tab-pane<?php if (isset($_GET['mail'])) echo ' active';?>">
                        <br>
                        <form method="post" action="modify_email.php">
                            <input type="hidden" name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey'];?>">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-user"></i></span>

                                        </div>
                                        <input type="text" class="form-control" id="user_id" value="<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-mail"></i></span>

                                        </div>
                                        <input type="email" class="form-control" name="email" placeholder="邮箱" id="newmail" value="<?php echo $row['email'];?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-outline-info">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="menu2" class="container tab-pane<?php if (isset($_GET['info'])) echo ' active';?>"><br>
                        <form method="post" action="modify_info.php">
                            <input type="hidden" name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey'];?>">
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label>用户名：</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-user"></i></span>

                                        </div>
                                        <input type="text" class="form-control" id="user_id" value="<?php echo $_SESSION[$OJ_NAME.'_'.'user_id'];?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label>昵称：</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-user"></i></span>

                                        </div>
                                        <input name="nick" class="form-control" value="<?php echo htmlentities($row['nick'],ENT_QUOTES,"UTF-8")?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label>学校：</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-user"></i></span>

                                        </div>
                                        <input name="school" class="form-control" value="<?php echo htmlentities($row['school'],ENT_QUOTES,"UTF-8")?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-outline-info">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php require( "./template/bshark/footer.php");?>
        <?php require( "./template/bshark/footer-files.php");?>
    </body>

</html>
