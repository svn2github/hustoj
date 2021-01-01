<?php $show_title="注册 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<div class="padding">
  <h1>注册</h1>
  <div class="ui error message" id="error" data-am-alert hidden>
    <p id="error_info"></p>
  </div>
          <form action="register.php" method="post" role="form" class="ui form">
                <div class="field">
                    <label for="username">用户名*</label>
                    <input name="user_id" class="form-control" placeholder="" type="text">
                </div>
                <div class="field">
                    <label for="username">昵称*</label>
                    <input name="nick" placeholder="" type="text">
                </div>
                <div class="two fields">
                    <div class="field">
                    <label class="ui header">密码*</label>
                      <input name="password" placeholder="" type="password">
                    </div>
                    <div class="field">
                      <label class="ui header">确认密码*</label>
                      <input name="rptpassword" placeholder="" type="password">
                    </div>
                </div>
                <div class="field">
                    <label for="username">个性签名</label>
                    <input name="school" placeholder="" type="text" value="">
                </div>
                <div class="field">
                    <label for="email">邮箱*</label>
                    <input name="email" placeholder="" type="text">
                </div>
                <?php if($OJ_VCODE){?>
                  <div class="field">
                    <label for="email">验证码*</label>
                    <input name="vcode" class="form-control" placeholder="" type="text">
                    <img alt="click to change" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()" height="30px">
                  </div>
                <?php }?>
                <button name="submit" type="submit" class="ui button">注册</button>
                <button name="submit" type="reset" class="ui button">重置</button>
            </form>
</div>
<?php include("template/$OJ_TEMPLATE/footer.php");?>
