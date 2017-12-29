<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

////////////////////////////Common head
        $cache_time=2;
        $OJ_CACHE_SHARE=false;
    require_once('./include/db_info.inc.php');
        require_once('./include/setlang.php');
        $view_title= "$MSG_STATUS";


require_once("./include/const.inc.php");



$solution_id=0;
// check the top arg

if (isset($_GET['solution_id'])){
        $solution_id=intval($_GET['solution_id']);
}
	if($OJ_MEMCACHE){
		$sql="select * from solution where solution_id=$solution_id  LIMIT 1";
		require("./include/memcache.php");
		$result = mysql_query_cache($sql);
		
	}else{
		$sql="select * from solution where solution_id=? LIMIT 1";
		$result = pdo_query($sql,$solution_id);
		
	}

	if ($result){
		$row=$result[0];
		if(isset($_GET['tr'])&&isset($_SESSION[$OJ_NAME.'_'.'user_id'])){
				$res=$row['result'];
			if($res==11){
				$sql="SELECT `error` FROM `compileinfo` WHERE `solution_id`=?";
			}else{
				$sql="SELECT `error` FROM `runtimeinfo` WHERE `solution_id`=?";
			}
			$result=pdo_query($sql,$solution_id);
			 $row=$result[0];
			if($row){
					echo htmlentities(str_replace("\n\r","\n",$row['error']),ENT_QUOTES,"UTF-8");
					$sql="delete from custominput where solution_id=?";
					pdo_query($sql,$solution_id);     
			}

		
			//echo $sql.$res;
		}else{
		    if(isset($_GET['q'])&&"user_id"==$_GET['q']){
			echo $row['user_id'];
		    }else{
			echo $row['result'].",".$row['memory'].",".$row['time'].",".$row['judger'];
		    }
		}
	}else{
		echo "0, 0, 0,unknown";
	}


?>
