<?php
	$cache_time=10;
	$OJ_CACHE_SHARE=false;
	require_once('./include/cache_start.php');
	require_once('./include/db_info.inc.php');
	require_once('./include/my_func.inc.php');
	require_once('./include/setlang.php');
	 
	if(isset($OJ_EXAM_CONTEST_ID)&&$OJ_EXAM_CONTEST_ID>0){
		header("Content-type: text/html; charset=utf-8");
		echo $MSG_MAIL_NOT_ALLOWED_FOR_EXAM;
		exit ();
	}

	$view_title=$MSG_MAIL;
 $to_user="";
$title="";
if (isset($_GET['to_user'])){
	$to_user=htmlentities($_GET['to_user'],ENT_QUOTES,"UTF-8");
}
if (isset($_GET['title'])){
	$title=htmlentities($_GET['title'],ENT_QUOTES,"UTF-8");
}

if (!isset($_SESSION['user_id'])){
	echo "<a href=loginpage.php>$MSG_Login</a>";
	require_once("oj-footer.php");
	exit(0);
}
require_once("./include/db_info.inc.php");
require_once("./include/const.inc.php");
if(isset($OJ_LANG)){
		require_once("./lang/$OJ_LANG.php");
		if(file_exists("./faqs.$OJ_LANG.php")){
			$OJ_FAQ_LINK="faqs.$OJ_LANG.php";
		}
}
echo "<title>$MSG_MAIL</title>";



//view mail
$view_content=false;
if (isset($_GET['vid'])){
	$vid=intval($_GET['vid']);
	$sql="SELECT * FROM `mail` WHERE `mail_id`=".$vid."
								and to_user='".$_SESSION['user_id']."'";
	$result=mysqli_query($mysqli,$sql);
	$row=mysqli_fetch_object($result);
	$to_user=$row->from_user;
	$view_title=$row->title;
	$view_content=$row->content;

	mysqli_free_result($result);
	$sql="update `mail` set new_mail=0 WHERE `mail_id`=".$vid;
	mysqli_query($mysqli,$sql);

}
//send mail page
//send mail
if(isset($_POST['to_user'])){
	$to_user = $_POST ['to_user'];
	$title = $_POST ['title'];
	$content = $_POST ['content'];
	$from_user=$_SESSION['user_id'];
	if (get_magic_quotes_gpc ()) {
		$to_user = stripslashes ( $to_user);
		$title = stripslashes ( $title);
		$content = stripslashes ( $content );
	}
	$title = RemoveXSS( $title);
	$to_user=mysqli_real_escape_string($mysqli,$to_user);
	$title=mysqli_real_escape_string($mysqli,$title);
	$content=mysqli_real_escape_string($mysqli,$content);
	$from_user=mysqli_real_escape_string($mysqli,$from_user);
	$sql="select 1 from users where user_id='$to_user' ";
	$res=mysqli_query($mysqli,$sql);
	if ($res&&mysqli_num_rows($res)<1){
			mysqli_free_result($res);
			$view_title= "No Such User!";

	}else{
		if($res)mysqli_free_result($res);
		$sql="insert into mail(to_user,from_user,title,content,in_date)
						values('$to_user','$from_user','$title','$content',now())";

		if(!mysqli_query($mysqli,$sql)){
			$view_title=  "Not Mailed!";
		}else{
			$view_title=  "Mailed!";
		}
	}
}
//list mail
	$sql="SELECT * FROM `mail` WHERE to_user='".$_SESSION['user_id']."'
					order by mail_id desc";
	$result=mysqli_query($mysqli,$sql) or die(mysqli_error());
$view_mail=Array();
$i=0;
for (;$row=mysqli_fetch_object($result);){
	$view_mail[$i][0]=$row->mail_id;
	if ($row->new_mail) $view_mail[$i][0].= "<span class=red>New</span>";
	$view_mail[$i][1]="<a href='mail.php?vid=$row->mail_id'>".
			$row->from_user.":".$row->title."</a>";
	$view_mail[$i][2]=$row->in_date;
	$i++;
}
mysqli_free_result($result);


/////////////////////////Template
require("template/".$OJ_TEMPLATE."/mail.php");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>

