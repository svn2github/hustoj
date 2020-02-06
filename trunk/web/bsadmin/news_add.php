<?php
require_once ("header-files.php");
require_once("../include/check_post_key.php");
    if ($mod=='hacker') {
        header("Location:index.php");
    }

require_once("../include/db_info.inc.php");
require_once("../include/my_func.inc.php");

//contest_id
$title = $_POST['title'];
$content = $_POST['content'];

$user_id = $_SESSION[$OJ_NAME.'_'.'user_id'];

if(get_magic_quotes_gpc()){
  $title = stripslashes($title);
  $content = stripslashes($content);
}

$content = str_replace("<p>", "", $content);
$content = str_replace("</p>", "<br />", $content);
$content = str_replace(",", "&#44;", $content);

$title=RemoveXSS($title);
$content=RemoveXSS($content);

$sql = "INSERT INTO news(`user_id`,`title`,`content`,`time`) VALUES(?,?,?,now())";
pdo_query($sql,$user_id,$title,$content);

echo "<script>window.location.href=\"news_list.php\";</script>";
?>
