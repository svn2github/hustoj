<?php
require("admin-header.php");
if(isset($OJ_LANG)){
  require_once("../lang/$OJ_LANG.php");
}
?>

<title>User List</title>
<hr>
<center><h3><?php echo $MSG_USER.$MSG_LIST?></h3></center>

<div class='container'>

<?php
require_once("../include/set_get_key.php");

$sql = "";

if(isset($_GET['keyword'])){
  $keyword = $_GET['keyword'];
  $keyword = "%$keyword%";
  $sql = "SELECT `user_id`,`nick`,`reg_time`,`ip`,`school`,`defunct` FROM `users` WHERE user_id LIKE ? ";
  $result = pdo_query($sql,$keyword);
}else{
  $sql = "SELECT `user_id`,`nick`,`reg_time`,`ip`,`school`,`defunct` FROM `users` ORDER BY `reg_time` DESC LIMIT 100 ";
  $result = pdo_query($sql);
}
?>

<form action=user_list.php class=center>
  <input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>" >
</form>


<center>
  <table width=100% border=1 style="text-align:center;">
    <tr>
      <td>ID</td>
      <td>NICK</td>
      <td>SCHOOL</td>
      <td>SIGN UP</td> 
      <td>USE</td>
<!--      <td>IP</td>  -->
    </tr>

<?php
foreach($result as $row){
  echo "<tr>";
    echo "<td><a href='../userinfo.php?user=".$row['user_id']."'>".$row['user_id']."</a></td>";
    echo "<td>".$row['nick']."</td>";
    echo "<td>".$row['school']."</td>";
    echo "<td>".$row['reg_time']."</td>";
    $cid=$row['user_id'];
    if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
      echo "<td><a href=user_df_change.php?cid=".$row['user_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>AVAILABLE</span>":"<span class=red>LOCKED</span>")."</a></td>";
    }else{
      echo "<td>No permissions</td>";
    }
//  echo "<td>".$row['ip'];
  echo "</tr>";
}

echo "</table></center>";

require("../oj-footer.php");
?>
</div>
