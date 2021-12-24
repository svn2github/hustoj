<?php include("template/$OJ_TEMPLATE/header.php");?>
<div class="padding">
  <h1>修改用户信息</h1>
  <div class="ui error message" id="error" data-am-alert hidden>
    <p id="error_info"></p>
  </div>
          <form action="modify.php" method="post" role="form" class="ui form">
                <div class="field">
                    <label for="username">用户名</label>
                    <input class="form-control" placeholder="请输入用户名"  disabled="disabled" type="text" value="<?php echo $_SESSION[$OJ_NAME.'_'.'user_id']?>">
                </div>
                <?php require_once('./include/set_post_key.php');?>
                <div class="field">
                    <label for="username">昵称*</label>
                    <input name="nick" placeholder="请输入昵称" type="text" value="<?php echo htmlentities($row['nick'],ENT_QUOTES,"UTF-8")?>">
                </div>
                <div class="field">
                    <label class="ui header">密码*</label>
                      <input name="opassword" placeholder="请输入密码" type="password">
                    </div>
                <div class="two fields">
                    <div class="field">
                    <label class="ui header">新密码</label>
                      <input name="npassword" placeholder="无需修改密码，请勿填写此项" type="password">
                    </div>
                    <div class="field">
                      <label class="ui header">确认新密码</label>
                      <input name="rptpassword" placeholder="无需修改密码，请勿填写此项" type="password">
                    </div>
                </div>
                <div class="field">
                    <label for="username">个性签名</label>
                    <input name="school" placeholder="请输入个性签名" type="text" value="<?php echo htmlentities($row['school'],ENT_QUOTES,"UTF-8")?>">
                </div>
                <div class="field">
                    <label for="email">邮箱*</label>
                    <input name="email" placeholder="请输入邮箱" type="text" value="<?php echo htmlentities($row['email'],ENT_QUOTES,"UTF-8")?>">
                </div>
                <?php if($OJ_VCODE){?>
                  <div class="field">
                    <label for="email">验证码*</label>
                    <input name="vcode" class="form-control" placeholder="请输入验证码" type="text">
                    <img alt="click to change" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()" height="30px">
                  </div>
                <?php }?>
                <button name="submit" type="submit" class="ui button">修改</button>
                <button name="submit" type="reset" class="ui button">重置</button>
            </form>
</div>
<?php if ($OJ_SaaS_ENABLE && $domain==$DOMAIN){ ?>
  <div class="center"> <a name='MyOJ'>&nbsp;</a> <label >My OJ:</label>
          <form action="saasinit.php" method="post" role="form" class="ui form">
                <div class="field">
                    <label for="template">模板</label>
                    <select name="template" class="form-control" >
                                <option>bs3</option>
                                <option>mdui</option>
                                <option>syzoj</option>
                                <option>sweet</option>
                                <option>bshark</option>
                                <option>mario</option>
                    </select>
                </div>

                <div class="field">
                    <label for="friendly">友善级别</label>
                    <select name="friendly" class="form-control" >
                                <option value=0>0=不友善</option>
                                <option value=1>1=0+中国时区</option>
                                <option value=2>2=1+强制中文</option>
                                <option value=3>3=2+显示对比,关闭验证码</option>
                                <option value=4>4=3+开启内邮,代码自动分享</option>
                                <option value=5>5=4+开启测试运行</option>
                                <option value=6>6=5+保持登陆状态</option>
                                <option value=7>7=6+开启讨论版</option>
                                <option value=8>8=7+可以下载测试数据</option>
                                <option value=9>9=8+允许访客提交</option>
                    </select>
                </div>
                <button name="submit" type="submit" class="ui button">重新初始化</button>
            </form>
   </div>
<?php } ?>

<?php include("template/$OJ_TEMPLATE/footer.php");?>
