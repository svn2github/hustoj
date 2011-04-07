<?require_once("oj-header.php")?>
<?
$to_user="";
if (isset($_GET['to_user'])){
	$to_user=htmlspecialchars($_GET['to_user']);
}
if (!isset($_SESSION['user_id'])){
	echo "<a href=loginpage.php>Please Login First</a>";
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
if (isset($_GET['vid'])){
	$vid=intval($_GET['vid']);
	$sql="SELECT * FROM `mail` WHERE `mail_id`=".$vid."
								and to_user='".$_SESSION['user_id']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_object($result);
	$to_user=$row->from_user;
	
	echo "<center>
	<table>
			<tr>
				<td><font color=blue>$to_user</font>:".htmlspecialchars(str_replace("\n\r","\n",$row->title))." </td>
			</tr>
			<tr><td><pre>". htmlspecialchars(str_replace("\n\r","\n",$row->content))."</pre>		
				</td></tr>
    </table></center>";
	mysql_free_result($result);
	$sql="update `mail` set new_mail=0 WHERE `mail_id`=".$vid;
	mysql_query($sql);
	
}
//send mail page 

?> 
<center>
   <table><form method=post action=mail.php>
	<tr>
		<td>  To:<input name=to_user size=10 value="<?=$to_user?>">
	 Title:<input name=title size=20><input type=submit value=<?=$MSG_SUBMIT?>></td>
	</tr>
	<tr><td> 
		<textarea name=content rows=10 cols=50></textarea>
	  
	 </td></tr>
	</form>
   </table>
</center> 
	 

<?
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
	$to_user=mysql_real_escape_string($to_user);
	$title=mysql_real_escape_string($title);
	$content=mysql_real_escape_string($content);
	$from_user=mysql_real_escape_string($from_user);
	$sql="select 1 from users where user_id='$to_user' ";
	$res=mysql_query($sql);
	if ($res&&mysql_num_rows($res)<1){
			mysql_free_result($res);
			echo "No Such User!";
			require_once('oj-footer.php');
			exit(0);
	}
	if($res)mysql_free_result($res);
	$sql="insert into mail(to_user,from_user,title,content,in_date)
					values('$to_user','$from_user','$title','$content',now())";
	
	if(!mysql_query($sql)){
		echo "Not Mailed!<br>";
	}else{
		echo "Mailed!<br>";
	}
}
//list mail
	$sql="SELECT * FROM `mail` WHERE to_user='".$_SESSION['user_id']."'
					order by mail_id desc";
	$result=mysql_query($sql) or die(mysql_error());
echo "<center><table width=90% border=1>";
echo "<tr><td>Mail ID<td>From:Title<td>Date</tr>";
for (;$row=mysql_fetch_object($result);){
	echo "<tr>";
	echo "<td>".$row->mail_id;
	if ($row->new_mail) echo "<font color=red>New</font>";
	echo "<td><a href='mail.php?vid=$row->mail_id'>".
			$row->from_user.":".$row->title."</a>";
	echo "<td>".$row->in_date;
	echo "</tr>";
}
mysql_free_result($result);
echo "</tr></form>";
echo "</table></center>";

?>
<?require_once("oj-footer.php")?>
