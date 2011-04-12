<?
require_once("./include/db_info.inc.php");
/* 
*/

if(isset($_GET['id']))
	$pid=intval($_GET['id']);
else
	$pid=0;
if($OJ_BBS=="discuss"){
   header("Location:discuss/discuss.php?id=".$pid);

}else{

	if(isset($_GET['id'])){
	    header("Location:http://bbs.acm.zj.cn/search.php?fid[]=2&keywords=".$pid); //chenge this to your own phpBB search link
	}else{
	    header("Location:http://bbs.acm.zj.cn/");
	}
}
?>
