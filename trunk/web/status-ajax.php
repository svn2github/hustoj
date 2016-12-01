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

	$sql="select * from solution where solution_id=$solution_id LIMIT 1";
	//echo $sql;

	if($OJ_MEMCACHE){
		require("./include/memcache.php");
		$result = mysql_query_cache($sql);// or die("Error! ".mysqli_error());
		if($result) $rows_cnt=count($result);
		else $rows_cnt=0;
	}else{

		$result = mysqli_query($mysqli,$sql);// or die("Error! ".mysqli_error());
		if($result) $rows_cnt=mysqli_num_rows($result);
		else $rows_cnt=0;
	}

	for ($i=0;$i<$rows_cnt;$i++){
	if($OJ_MEMCACHE)
		$row=$result[$i];
	else
		$row=mysqli_fetch_array($result);

	if(isset($_GET['tr'])){
        	$res=$row['result'];
		if($res==11){
			$sql="SELECT `error` FROM `compileinfo` WHERE `solution_id`='".$solution_id."'";
		}else{
			$sql="SELECT `error` FROM `runtimeinfo` WHERE `solution_id`='".$solution_id."'";
		}
		$result=mysqli_query($mysqli,$sql);
		$row=mysqli_fetch_array($result);
		if($row){
                        echo htmlentities(str_replace("\n\r","\n",$row['error']),ENT_QUOTES,"UTF-8");
                        $sql="delete from custominput where solution_id=".$solution_id;
    			mysqli_query($mysqli,$sql);     
                }

    
		//echo $sql.$res;
	}else{
		echo $row['result'].",".$row['memory'].",".$row['time'];
	}
}

if(!$OJ_MEMCACHE)mysqli_free_result($result);

?>

