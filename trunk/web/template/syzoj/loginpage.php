<?php $show_title="登陆 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>

<div class="ui error message" id="error" hidden></div>
<div class="ui middle aligned center aligned grid"  style="height: 500px;" >
  <div class="row">
    <div class="column" style="max-width: 450px">
      <h2 class="ui image header">
        <div class="content" style="margin-bottom: 10px; ">
          登录
        </div>
      </h2>
      <form class="ui large form" id="login" action="login.php" method="post" role="form" class="form-horizontal" onSubmit="return jsMd5();" >
        <div class="ui existing segment">
          <div class="field">
            <div class="ui left icon input">
              <i class="user icon"></i>
              <input name="user_id" placeholder="用户名" type="text" id="username">
            </div>
          </div>
          <div class="field">
            <div class="ui left icon input">
              <i class="lock icon"></i>
              <input name="password" placeholder="密码" type="password" id="password">
            </div>
          </div>
          <?php if($OJ_VCODE){?>
            <div class="field">
              <div class="ui left icon input">
                <i class="lock icon"></i>
                <input name="vcode" placeholder="验证码" type="text">
                <img id="vcode-img" onclick="this.src='vcode.php?'+Math.random()" height="30px">
              </div>
            </div>
          <?php }?>
          <button name="submit" type="submit" class="ui fluid large submit button" >登录</button>
        </div>

        <div class="ui error message"></div>

      </form>

      <div class="ui message">
        <a href="registerpage.php">注册账号</a>
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
        <!-- <a href="lostpassword.php">忘记密码</a> -->
      </div>
    </div>
  </div>
</div>
<script src="<?php echo $OJ_CDN_URL?>include/md5-min.js"></script>
<script>
  function jsMd5(){
    if($("input[name=password]").val()=="") return false;
    $("input[name=password]").val(hex_md5($("input[name=password]").val()));
    return true;
  }
</script>
<?php if ($OJ_VCODE) { ?>
    <script>
        $(document).ready(function () {
            $("#vcode-img").attr("src", "vcode.php?" + Math.random());
        })
    </script>
<?php } ?>


<?php include("template/$OJ_TEMPLATE/footer.php");?>
