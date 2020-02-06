<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>修改信息 - MasterOJ</title>
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
                    <li class="nav-item"> <a class="nav-link<?php if (isset($_GET['theme'])) echo ' active';?>" href="?theme">个性化</a>

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
                            <!--script>
                                var old_email = '<?php echo $row['email'];?>';
                                var if_check = <?php echo $row['mailok'];?>;
                                var timeDown;
                                var cmb = document.getElementById("check_mail_btn");
                                if (if_check == 1) {
                                    cmb.className="btn btn-outline-dark disabled";
                                    cmb.innerHTML="已验证";
                                }
                                else {
                                    cmb.className="btn btn-outline-dark";
                                    cmb.innerHTML="发送验证邮件";
                                }
                                var out = setInterval(function() {
                                    if (timeDown < 0) timeDown = 0;
                                    if (old_email == newmail.value) {
                                        if (if_check != 1) {
                                            if (timeDown > 0) {
                                                cmb.className="btn btn-outline-dark disabled";
                                                cmb.innerHTML="发送验证邮件("+timeDown+")";
                                            }
                                            else {
                                                cmb.className="btn btn-outline-dark";
                                                cmb.innerHTML="发送验证邮件";
                                            }
                                        }
                                    }
                                    else {
                                        if (timeDown > 0) {
                                            cmb.className="btn btn-outline-dark disabled";
                                            cmb.innerHTML="发送验证邮件("+timeDown+")";
                                        }
                                        else {
                                            cmb.className="btn btn-outline-dark";
                                            cmb.innerHTML="发送验证邮件";
                                        }
                                    }
                                    if (timeDown > 0) timeDown -- ;
                                },1000);
                                function send() {
                                    alert("OK, the mail is sent");
                                    timeDown = 180;
                                }
                            </script-->
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
                                    <label>QQ：</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-qq"></i></span>

                                        </div>
                                        <input name="qq" class="form-control" value="<?php echo htmlentities($row['qq'],ENT_QUOTES,"UTF-8")?>" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label>个性签名</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-qianming"></i></span>

                                        </div>
                                    <textarea class="form-control" name="school" style="height:100px"><?php echo htmlentities($row['school'],ENT_QUOTES,"UTF-8")?>
                                    </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <fieldset><div class="custom-control custom-toggle d-block my-2"><input type="checkbox" id="codeshare" name="codeshare" class="custom-control-input"<?php if ($row['codeshare']) { ?> checked="checked"<?php } ?>><label class="custom-control-label" for="codeshare">代码共享</label></div></fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-outline-info">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div id="menu3" class="container tab-pane<?php if (isset($_GET['theme'])) echo ' active';?>">
                        <br>
                        导航栏及底部设置
                        <a class="badge bg-light text-dark" href="#" onclick="setStyle(0)">Light</a>
        <a class="badge bg-primary text-light" href="#" onclick="setStyle(1)">Primary</a>
        <a class="badge bg-info text-light" href="#" onclick="setStyle(2)">Info</a>
        <a class="badge bg-success text-light" href="#" onclick="setStyle(3)">Success</a>
        <a class="badge bg-warning text-light" href="#" onclick="setStyle(4)">Warning</a>
        <a class="badge bg-danger text-light" href="#" onclick="setStyle(5)">Danger</a>
        <a class="badge bg-secondary text-light" href="#" onclick="setStyle(6)">Secondary</a>
        <a class="badge bg-dark text-light" href="#" onclick="setStyle(7)">Dark</a>
        <a class="badge bg-colorful text-light" href="#" onclick="setStyle(8)">Colorful</a><br>
                        Shards设置(<a href="#" id="shardsinfo" onclick="shardcg()"></a>)
                        <br>
                        <form action="modify_backimg.php" method="post">
                            背景图片地址
                            <?php echo $_SESSION[$OJ_NAME.'_'.'postkey'];?>
                            <input type='hidden' name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey'];?>">
                            <input name=backimg type="text" class="form-control" value="<?php echo $row['backimg'];?>">
                            <button type=submit class="btn btn-dark">设置背景图片</button>
                            <span>可以用<code>./template/bshark/bingimg.php</code>获取bing每日图片</span>
                        </form>
                        <br>
                            不透明度
                            <input id="tmddd" type="text" class="form-control" value="">
                            <button onclick="setTmd()" class="btn btn-info">设置不透明度</button>
                    </div>
                </div>
            </div>
        </div>
        <?php require( "./template/bshark/footer.php");?>
        <?php require( "./template/bshark/footer-files.php");?>
    </body>

</html>