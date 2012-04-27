<?php 
	$OJ_CACHE_SHARE=true;
	$cache_time=1;
	require_once('./include/cache_start.php');
    require_once('./include/db_info.inc.php');
	require_once('./include/setlang.php');
	$view_title= $MSG_CONTEST.$MSG_RANKLIST;
	require_once("./include/const.inc.php");
	require_once("./include/my_func.inc.php");
class TM{
	var $solved=0;
	var $time=0;
	var $p_wa_num;
	var $p_ac_sec;
	var $user_id;
        var $nick;
	function TM(){
		$this->solved=0;
		$this->time=0;
		$this->p_wa_num=array(0);
		$this->p_ac_sec=array(0);
	}
	function Add($pid,$sec,$res){
//		echo "Add $pid $sec $res<br>";
		if (isset($this->p_ac_sec[$pid])&&$this->p_ac_sec[$pid]>0)
			return;
		if ($res!=4){
			if(isset($this->p_wa_num[$pid])){
				$this->p_wa_num[$pid]++;
			}else{
				$this->p_wa_num[$pid]=1;
			}
		}else{
			$this->p_ac_sec[$pid]=$sec;
			$this->solved++;
			if(!isset($this->p_wa_num[$pid])) $this->p_wa_num[$pid]=0;
			$this->time+=$sec+$this->p_wa_num[$pid]*1200;
//			echo "Time:".$this->time."<br>";
//			echo "Solved:".$this->solved."<br>";
		}
	}
}

function s_cmp($A,$B){
//	echo "Cmp....<br>";
	if ($A->solved!=$B->solved) return $A->solved<$B->solved;
	else return $A->time>$B->time;
}

// contest start time
if (!isset($_GET['cid'])) die("No Such Contest!");
$cid=intval($_GET['cid']);

$sql="SELECT `start_time`,`title` FROM `contest` WHERE `contest_id`='$cid'";
$result=mysql_query($sql) or die(mysql_error());
$rows_cnt=mysql_num_rows($result);
$start_time=0;
if ($rows_cnt>0){
	$row=mysql_fetch_array($result);
	$start_time=strtotime($row[0]);
	$title=$row[1];
}
mysql_free_result($result);
if ($start_time==0){
	$view_errors= "No Such Contest";
	require("template/".$OJ_TEMPLATE."/error.html");
	exit(0);
}

if ($start_time>time()){
	$view_errors= "Contest Not Started!";
	require("template/".$OJ_TEMPLATE."/error.html");
	exit(0);
}

$sql="SELECT count(1) FROM `contest_problem` WHERE `contest_id`='$cid'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$pid_cnt=intval($row[0]);
mysql_free_result($result);

$sql="SELECT 
	users.user_id,users.nick,solution.result,solution.num,solution.in_date 
		FROM 
			(select * from solution where solution.contest_id='$cid' and num>=0) solution 
		left join users 
		on users.user_id=solution.user_id 
	ORDER BY users.user_id,in_date";
//echo $sql;
$result=mysql_query($sql);
$user_cnt=0;
$user_name='';
$U=array();
while ($row=mysql_fetch_object($result)){
	$n_user=$row->user_id;
	if (strcmp($user_name,$n_user)){
		$user_cnt++;
		$U[$user_cnt]=new TM();
		$U[$user_cnt]->user_id=$row->user_id;
                $U[$user_cnt]->nick=$row->nick;

		$user_name=$n_user;
	}
	$U[$user_cnt]->Add($row->num,strtotime($row->in_date)-$start_time,intval($row->result));
}
mysql_free_result($result);
usort($U,"s_cmp");

/////////////////////////Template
require("template/".$OJ_TEMPLATE."/contestrank.html");
/////////////////////////Common foot
if(file_exists('./include/cache_end.php'))
	require_once('./include/cache_end.php');
?>
