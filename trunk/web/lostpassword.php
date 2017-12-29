<?php
        require_once('./include/db_info.inc.php');
        require_once('./include/setlang.php');
        $view_title= "Welcome To Online Judge";

require_once("./include/const.inc.php");
require_once("./include/my_func.inc.php");
$lost_user_id=$_POST['user_id'];
$lost_email=$_POST['email'];
    if(isset($_POST['vcode']))$vcode=trim($_POST['vcode']);
    if($lost_user_id&&($vcode!= $_SESSION[$OJ_NAME.'_'."vcode"]||$vcode==""||$vcode==null) ){
                echo "<script language='javascript'>\n";
                echo "alert('Verify Code Wrong!');\n";
                echo "history.go(-1);\n";
                echo "</script>";
                exit(0);
    }
  if(get_magic_quotes_gpc()){
        $lost_user_id=stripslashes($lost_user_id);
        $lost_email=stripslashes($lost_email);
  }
  $sql="SELECT `email` FROM `users` WHERE `user_id`=?";
                $result=pdo_query($sql,$lost_user_id);
                $row = $result[0];
 if($row && $row['email']==$lost_email&&strpos($lost_email,'@')){
   $_SESSION[$OJ_NAME.'_'.'lost_user_id']=$lost_user_id;
   $_SESSION[$OJ_NAME.'_'.'lost_key']=getToken(16);

  
	require_once "include/email.class.php";
	//******************** 配置信息 ********************************
	$smtpserver = "smtp.126.com";//SMTP服务器
	$smtpserverport =25;//SMTP服务器端口
	$smtpusermail = "zjicm_oj_system@126.com";//SMTP服务器的用户邮箱
	$smtpemailto = $row['email'];//发送给谁
	$smtpuser = "zjicm_oj_system@126.com";//SMTP服务器的用户帐号
	$smtppass = "hustoj2015";//SMTP服务器的用户密码
	$mailtitle = "OJ系统密码重置激活";//邮件主题
	$mailcontent = "$lost_user_id:\n您好！\n您在OJ系统选择了找回密码服务,为了验证您的身份,请将下面字串输入口令重置页面以确认身份:".$_SESSION[$OJ_NAME.'_'.'lost_key']."\n\n\n浙江传媒学院在线评测系统";//邮件内容
	$mailtype = "TXT";//邮件格式（HTML/TXT）,TXT为文本邮件
	//************************ 配置信息 ****************************
	$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
	$smtp->debug =false;//是否显示发送的调试信息
	$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
        require("template/".$OJ_TEMPLATE."/lostpassword2.php");

 }else{

/////////////////////////Template
   require("template/".$OJ_TEMPLATE."/lostpassword.php");

}
/////////////////////////Common foot
?>
