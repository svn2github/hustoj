<?php
        require_once('./include/db_info.inc.php');
        require_once('./include/setlang.php');
        $view_title= "Welcome To Online Judge";

require_once("./include/const.inc.php");
require_once("./include/my_func.inc.php");
$lost_user_id=$_POST['user_id'];
$lost_key=$_POST['lost_key'];
    $vcode=trim($_POST['vcode']);
    if($lost_user_id==$_SESSION['lost_user_id']&&($vcode!= $_SESSION["vcode"]||$vcode==""||$vcode==null) ){
                echo "<script language='javascript'>\n";
                echo "alert('Verify Code Wrong!');\n";
                echo "history.go(-1);\n";
                echo "</script>";
                exit(0);
    }
  if(get_magic_quotes_gpc()){
        $lost_user_id=stripslashes($lost_user_id);
        $lost_key=stripslashes($lost_key);
  }
  $sql=" update `users` set password='".pwGen($lost_key)."'WHERE `user_id`='".mysqli_real_escape_string($mysqli,$lost_user_id)."'";
  if(

   $_SESSION['lost_user_id']==$lost_user_id &&
   $_SESSION['lost_key']==$lost_key
  ){
         $result=mysqli_query($mysqli,$sql);
    $view_errors="Password Reseted to the key you've just inputed.Click <a href=index.php>Here</a> to login!";
  }else{
         $view_errors="Password Reset Fail";
  }


  require("template/".$OJ_TEMPLATE."/error.php");
/////////////////////////Template

/////////////////////////Common foot
?>
