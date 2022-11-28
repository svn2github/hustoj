<?php
require("admin-header.php");
require_once("../include/set_get_key.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if(isset($OJ_LANG)){
  require_once("../lang/$OJ_LANG.php");
}
?>

<title>Solution Statistics</title>
<hr>
<center><h3><?php echo "Report:"?></h3></center>

<div class='container'>

<?php
if(isset($_POST['pids'])){

  $user_ida = explode("\n", trim($_POST['ulist']));
  $user_ida = array_unique($user_ida);
  $user_ids="";
  if(count($user_ida)>0 && strlen($user_ida[0])>0){
  $len=count($user_ida);	  
    for($i=0; $i<$len; $i++){
      if($user_ids) $user_ids.=",";
      $user_ids.="?";
      $user_ida[$i]=trim($user_ida[$i]);
    }
  }
  //echo implode(",",$user_ida),"<br>";
  


  $sql="select user_id,nick ";
  $pida=array_unique(explode(',',$_POST['pids']));
  $len=count($pida);
  for($i=0;$i<$len;$i++){
  	$pida[$i]=intval($pida[$i]);
  }
  $pida=array_unique($pida);
  foreach($pida as $pid){
  	$sql.=" ,min(case problem_id when $pid then result else 15 end) P$pid";
  }
  //$user_ids=implode("','",$user_ida);
  $sql.=" from solution where user_id in ($user_ids) group by user_id,nick ";
  //echo $sql;
  $result = pdo_query($sql,$user_ida);
?>


<center>
  <table width=100% border=1 style="text-align:center;">
    <?php
      echo "<td>USER_ID</td>";
      echo "<td>NICK</td>";
  	foreach($pida as $pid){
      		echo "<td>P".$pid;
      		echo "</td>";
	}
  //var_dump($result);
    foreach($result as $row){
      echo "<tr>";
      echo "<td>".$row['user_id']."</td>";
      echo "<td>".$row['nick']."</td>";
  	foreach($pida as $pid){
      		echo "<td>";
      		if($row["P$pid"]==4) echo "<span class='label label-success label-sm' >AC</span>";
		else if($row["P$pid"]==15) echo "&nbsp;";
		else echo "<span class='label label-danger label-sm' >WA</span>";
      		echo "</td>";
	}
      echo "</tr>";
    }
  ?>
</table>
<a href="javascript:history.go(-1);" >Back</a>
</center>

<?php
}else{

?>

	<center>
	<form action=solution_statistics.php method='post' class="form-search form-inline">
	  <input type="text" name=pids class="form-control" placeholder="1000,1001" size=128 >
              <textarea name='ulist' rows='10' style='width:100%;' placeholder='user1<?php echo "\n"?>user2<?php echo "\n"?>user3<?php echo "\n"?></textarea>
	  <button type="submit" class="form-control"><?php echo $MSG_SEARCH?></button>
	</form>
	</center>
	</div>
<?php

}
?>
