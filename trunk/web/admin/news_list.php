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
$sql = "SELECT max(`news_id`) AS upid, min(`news_id`) AS btid FROM `news`";
$page_cnt = 20;
$result = pdo_query($sql);
$row = $result[0];
$base = intval($row['btid']);
$cnt = intval($row['upid'])-$base;
$cnt = intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);

if(isset($_GET['page'])){
  $page = intval($_GET['page']);
}else 
  $page = $cnt;

$pstart = $base+$page_cnt*intval($page-1);
$pend = $pstart+$page_cnt;
?>

<?php
$sql = "";
if(isset($_GET['keyword'])){
  $keyword = $_GET['keyword'];
  $keyword = "%$keyword%";
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` WHERE (title LIKE ?) OR (content LIKE ?) ORDER BY `news_id` DESC";
  $result = pdo_query($sql,$keyword,$keyword);
}else{
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` WHERE news_id>=? AND news_id <=? ORDER BY `news_id` DESC";
  $result = pdo_query($sql,$pstart,$pend);
}
?>

<form action=news_list.php class="center">
  <input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>">
</form>

<center>
  <table width=100% border=1 style="text-align:center;">
    <tr>
      <td>ID</td>
      <td>TITLE</td>
      <td>UPDATE</td>
      <td>NOW</td>
      <td>COPY</td>
<!--  <td>edit</td> -->
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr>";
        echo "<td>".$row['news_id']."</td>";
        //echo "<input type=checkbox name='pid[]' value='$row['problem_id']'>";
        echo "<td><a href='news_edit.php?id=".$row['news_id']."'>".$row['title']."</a>"."</td>";
        echo "<td>".$row['time']."</td>";
        echo "<td><a href=news_df_change.php?id=".$row['news_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>On</span>":"<span class=red>Off</span>")."</a>"."</td>";
       echo "<td><a href=news_add_page.php?cid=".$row['news_id'].">Copy</a></td>";
        //echo "<td><a href=news_edit.php?id=".$row['news_id'].">Edit</a>"."</td>";
      echo "</tr>";
    }
?>
    </form>
  </table>
<center>
<div style="display:inline;">
  <nav class="center">
    <ul class="pagination pagination-sm">
      <li class="page-item"><a href="news_list.php?page=1">&lt;&lt;</a></li>
      <?php
      if(!isset($page)) $page = 1;
      $page = intval($page);
      $section = 3;
      $start = $page>$section?$page-$section:1;
      $end = $page+$section>$cnt?$cnt:$page+$section;

      for($i=$start; $i<=$end; $i++){
        echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='news_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
      }
      ?>
      <li class="page-item"><a href="news_list.php?page=<?php echo $cnt?>">&gt;&gt;</a></li>
    </ul>
  </nav>
</div>
</div>