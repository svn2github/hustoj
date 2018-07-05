<?php
require("admin-header.php");
if(isset($OJ_LANG)){
  require_once("../lang/$OJ_LANG.php");
}
?>

<title>Privilege List</title>
<hr>
<center><h3><?php echo $MSG_PRIVILEGE.$MSG_LIST?></h3></center>

<div class='container'>

<?php
require_once("../include/set_get_key.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

$sql = "SELECT * FROM privilege WHERE rightstr IN ('administrator','source_browser','contest_creator','http_judge','problem_editor','password_setter','printer','balloon') ORDER BY user_id, rightstr";
$result = pdo_query($sql) ;
?>

<center>
  <table width=100% border=1 style="text-align:center;">
    <tr>
      <td>ID</td>
      <td>PRIVILEGE</td>
      <td>REMOVE</td>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr>";
        echo "<td>".$row['user_id']."</td>";
        echo "<td>".$row['rightstr']."</td>";
        echo "<td><a href=privilege_delete.php?uid={$row['user_id']}&rightstr={$row['rightstr']}&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">Delete</a></td>";
      echo "</tr>";
    }
    ?>
  </table>
</center>
</div>
