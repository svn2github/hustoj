<?php
    require_once('./include/db_info.inc.php');
    require_once('./include/const.inc.php');
    require_once('./include/memcache.php');
	require_once('./include/setlang.php');
	$view_title=$MSG_SUBMIT;
 if (!isset($_SESSION[$OJ_NAME.'_'.'user_id'])){

	$view_errors= "<a href=loginpage.php>$MSG_Login</a>";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
//	$_SESSION[$OJ_NAME.'_'.'user_id']="Guest";
 }
if ($_SERVER['REQUEST_METHOD']=="POST"){
	require_once("include/check_post_key.php");
}
 if(isset($_SESSION[$OJ_NAME.'_'.'balloon'])){
	$cid=intval($_GET['cid']);
	if(isset($_SESSION[$OJ_NAME.'_'.'balloon'])){
		if(isset($_GET['id'])){
			$id=intval($_GET['id']);
			pdo_query("update balloon set status=1 where balloon_id=?",$id);
		}
		if(isset($_POST['clean'])){
			pdo_query("delete from balloon where cid=?",$cid);
		}
		
		$sql="select * from solution where result=4 and contest_id=? and solution_id not in (select sid from balloon where cid=?) order by solution_id;";
		$result=pdo_query($sql,$cid,$cid);
	        foreach($result as $row){
		     $user_id=$row['user_id'];
		     $sid=$row['solution_id'];
		     $pid=$row['num'];
		     $sql="select balloon_id from balloon where user_id=? and cid=? and pid=?";
			//echo $sql;
		     if(count(pdo_query($sql,$user_id,$cid,$pid))==0){
			$sql="insert into balloon(user_id,sid,cid,pid,status) value(?,?,?,?,0)";
//			echo $sql."<br>".$user_id." ".$sid." ".$cid." ".$pid;
			pdo_query($sql,$user_id,$sid,$cid,$pid);
		     }		     
		}	
		$view_balloon=Array();
		$result=pdo_query("select * from balloon where cid= ? order by status,balloon_id limit 50",$cid);
		$i=0;
		foreach ($result as $row){
			$view_balloon[$i]=Array();
			$view_balloon[$i][0]=$row['balloon_id'];
			$view_balloon[$i][1]=$row['user_id'];
			$view_balloon[$i][2]= "<font color='".$ball_color[$row['pid']]."'>";
			if($row['status']==1)$view_balloon[$i][2].="$MSG_PRINT_DONE";
			else $view_balloon[$i][2].="$MSG_PRINT_PENDING";
			 $view_balloon[$i][2].="</font>";
			$view_balloon[$i][3]="<a href='balloon_view.php?id=".$row['balloon_id']."' target='_self'>$MSG_PRINTER</a>";
			
			$i++;
		}
		require("template/".$OJ_TEMPLATE."/balloon_list.php");
		exit(0);
	}else{
		if(isset($_POST['content'])){
			$sql="insert into balloon(user_id,in_date,status,content) values(?,now(),0,?)";
			pdo_query($sql,$_SESSION[$OJ_NAME.'_'.'user_id'],$_POST['content']);
			$view_errors= "$MSG_PRINT_PENDING";
			$view_errors.= "...<br>";
			$view_errors.= "$MSG_PRINT_WAITING";
		        require("template/".$OJ_TEMPLATE."/error.php");


		}else{
			require("template/".$OJ_TEMPLATE."/balloon_add.php");
			exit(0);
		}

	}	

 }else{

	$view_errors= "$MSG_PRINTER not available!";
	require("template/".$OJ_TEMPLATE."/error.php");
	exit(0);
 }
/////////////////////////Template
/////////////////////////Common foot
?>

