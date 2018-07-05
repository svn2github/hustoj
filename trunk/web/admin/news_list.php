<?php
require("admin-header.php");
require_once("../include/set_get_key.php");

if(!isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}
?>

<title>News List</title>
<hr>
<center><h3><?php echo $MSG_NEWS.$MSG_LIST ?></h3></center>

<div class='container'>
  <?php
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` order by `news_id` desc";
  $result=pdo_query($sql) ;
  ?>
  <center>
    <table width=100% border=1 style="text-align:center;">
      <form>
      <tr>
        <td>ID</td>
        <td>TITLE</td>
        <td>UPDATE</td>
        <td>NEWS</td>
<!--        <td>edit</td> -->
      </tr>
      <?php
      foreach($result as $row){
        echo "<tr>";
          echo "<td>".$row['news_id']."</td>";
          //echo "<input type=checkbox name='pid[]' value='$row['problem_id']'>";
          echo "<td><a href='news_edit.php?id=".$row['news_id']."'>".$row['title']."</a>"."</td>";
          echo "<td>".$row['time']."</td>";
          echo "<td><a href=news_df_change.php?id=".$row['news_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>On</span>":"<span class=red>Off</span>")."</a>"."</td>";
          //echo "<td><a href=news_edit.php?id=".$row['news_id'].">Edit</a>"."</td>";
        echo "</tr>";
      }
?>
      </form>
    </table>
  <center>
</div>