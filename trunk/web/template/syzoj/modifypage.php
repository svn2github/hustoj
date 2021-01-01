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
<?php include("template/$OJ_TEMPLATE/footer.php");?>
