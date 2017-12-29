<?php require("admin-header.php");

        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }

echo "<title>User List</title>";
echo "<center><h2>User List</h2></center>";
require_once("../include/set_get_key.php");
$sql="";
if(isset($_GET['keyword'])){
	$keyword=$_GET['keyword'];
	$keyword="%$keyword%";
	 $sql="select `user_id`,`nick`,`reg_time`,`ip`,`school`,`defunct` FROM `users` where user_id like ? ";
	 $result=pdo_query($sql,$keyword);
}else{
     $sql="select `user_id`,`nick`,`reg_time`,`ip`,`school`,`defunct` FROM `users`  order by `reg_time` desc limit 100 ";
	 $result=pdo_query($sql);
}
?>
<form action=user_list.php class=center><input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>" ></form>

<?php
echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td>UserID<td>Nick<td>Status<td>RegTime<td>IP<td>School";
echo "</tr>";
foreach($result as $row){
        echo "<tr>";
        echo "<td><a href='../userinfo.php?user=".$row['user_id']."'>".$row['user_id']."</a>";
        echo "<td>".$row['nick'];
        $cid=$row['user_id'];
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
                echo "<td><a href=user_df_change.php?cid=".$row['user_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>Available</span>":"<span class=red>Reserved</span>")."</a>";
        }else{
                echo "<td>No permissions";
        }
        echo "<td>".$row['reg_time'];
        echo "<td>".$row['ip'];
        echo "<td>".$row['school'];
        echo "</tr>";
}
echo "</table></center>";
require("../oj-footer.php");
?>
