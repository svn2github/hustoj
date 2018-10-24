<?php
$cur_path = "template/$OJ_TEMPLATE/"
?>
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Sign Up Login</title>
<!--    <link rel="stylesheet" href="css/login.css">-->
<!--    --><?php //include("template/$OJ_TEMPLATE/css.php");?>

    <link rel="stylesheet" href="<?php echo $cur_path?>css/login.css">


</head>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<body>

<div class="cotn_principal">
    <div class="cont_centrar">
        <div class="cont_login">
            <div class="cont_info_log_sign_up">
                <div class="col_md_login">
                    <div class="cont_ba_opcitiy">
                        <h2>LOGIN</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur.</p>
                        <button class="btn_login" onClick="cambiar_login()">LOGIN</button>
                    </div>
                </div>
                <div class="col_md_sign_up">
                    <div class="cont_ba_opcitiy">
                        <h2>SIGN UP</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur.</p>
                        <button class="btn_sign_up" onClick="cambiar_sign_up()">SIGN UP</button>
                    </div>
                </div>
            </div>
            <div class="cont_back_info">
                <div class="cont_img_back_grey"> <img src="<?php echo $cur_path?>img/page1_bg.jpg" alt="" /> </div>
            </div>
            <div class="cont_forms" >
                <div class="cont_img_back_"> <img src="<?php echo $cur_path?>img/page1_bg.jpg" alt="" /> </div>
                <form action="login.php" method="post" onSubmit="return jsMd5();">

                    <div class="cont_form_login"> <a href="#" onClick="ocultar_login_sign_up()" ><i class="material-icons">&#xE5C4;</i></a>
                        <h2>LOGIN</h2>
                        <input type="text" placeholder="用户名" name="user_id"/>
                        <input type="password" placeholder="密码" name="password" />
                        <button class="btn_login" type="submit">登录</button>
                    </div>

                </form>

                <form action="register.php" method="post" >

                    <div class="cont_form_sign_up"> <a href="#" onClick="ocultar_login_sign_up()"><i class="material-icons">&#xE5C4;</i></a>
                        <h2>SIGN UP</h2>
                        <input type="text" placeholder="用户名（学号）" name="user_id" />
                        <input type="text" placeholder="昵称" name="nick" />
                        <input type="password" placeholder="密码" name="password" />
                        <input type="password" placeholder="重复密码" name="rptpassword" />
                        <button class="btn_sign_up" type="submit">注册</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo $cur_path?>js/login.js"></script>
<?php //include("template/$OJ_TEMPLATE/js.php");?>
<!--<script src="js/login.js"></script>-->
<!-- <div style="text-align:center;">
<p>来源:<a href="http://www.mycodes.net/" target="_blank">源码之家</a></p>
</div> -->
</body>
</html>
<script src="<?php echo $OJ_CDN_URL?>include/md5-min.js"></script>
<script>
    function jsMd5(){
        if($("input[name=password]").val()=="") return false;
        $("input[name=password]").val(hex_md5($("input[name=password]").val()));
        return true;
    }
</script>
<!--<script>-->
<!--    function login() {-->
<!--        console.log('login')-->
<!--    }-->
<!--    function register() {-->
<!--        console.log('register')-->
<!--    }-->
<!--</script>-->
