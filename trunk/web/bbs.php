<?php require_once("./include/db_info.inc.php");
/* 
*/

if(isset($_GET['pid']))
	$pid=intval($_GET['pid']);
else
	$pid=0;
if(isset($_GET['cid']))
	$cid=intval($_GET['cid']);
else
	$cid=0;
if($OJ_BBS=="discuss"){
   header("Location:discuss/discuss.php?".$_SERVER["QUERY_STRING"]);

}else{

	if(isset($_GET['pid'])){
	    header("Location:http://bbs.acm.zj.cn/search.php?fid[]=2&keywords=".$pid); //chenge this to your own phpBB search link
	}else{
	    header("Location:http://bbs.acm.zj.cn/");
	}
}
?>
