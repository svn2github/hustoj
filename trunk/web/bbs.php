<?
$pid=(int)$_GET['id'];
if($pid>0){
$pid="p".$pid;
    header("Location:bbs/search.php?fid[]=2&keywords=".$pid); //chenge this to your own phpBB search link
}else{
    header("Location:bbs/");
}
?>
