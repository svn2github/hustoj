<?php 
	require_once('../include/db_info.inc.php');
	require_once('../include/setlang.php');
	require_once('../include/const.inc.php');
	if(isset($_GET['tid'])&&!isset($_GET['cid'])){
		$tid=intval($_GET['tid']);
		$cid=pdo_query("select cid from topic where tid=?",$tid)[0][0];
		if($cid>0) $_GET['cid']=$cid;
//		echo "cid:".$cid;

	}
   ob_start();
?>
