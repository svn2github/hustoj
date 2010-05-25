<?
require_once("./include/db_info.inc.php");
/* 
*/
$pid=(int)$_GET['id'];

if($OJ_BBS=="discuss"){
   header("Location:discuss/discuss.php?id=".$pid);

}else{

	if($pid>0){
	$pid="p".$pid;
	    header("Location:bbs/search.php?fid[]=2&keywords=".$pid); //chenge this to your own phpBB search link
	}else{
	    header("Location:bbs/");
	}
}
?>
