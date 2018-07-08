<?php
require("admin-header.php");

if(!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'contest_creator']))){
  echo "<a href='../loginpage.php'>Please Login First!</a>";
  exit(1);
}

if(isset($OJ_LANG)){ require_once("../lang/$OJ_LANG.php");}
?>

<title>Contest List</title>
<hr>
<center><h3><?php echo $MSG_CONTEST.$MSG_LIST?></h3></center>

<?php
echo "<div class=\"container\">";

require_once("../include/set_get_key.php");

$sql = "SELECT max(`contest_id`) AS upid, min(`contest_id`) AS btid FROM `contest`";
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

/*
for ($i=1;$i<=$cnt;$i++){
        if ($i>1) echo '&nbsp;';
        if ($i==$page) echo "<span class=red>$i</span>";
        else echo "<a href='contest_list.php?page=".$i."'>".$i."</a>";
}
*/

$sql = "";
if(isset($_GET['keyword'])){
  $keyword = $_GET['keyword'];
  $keyword = "%$keyword%";
  $sql = "SELECT `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` WHERE (title LIKE ?) OR (description LIKE ?) ORDER BY `contest_id` DESC";
  $result = pdo_query($sql,$keyword,$keyword);
}else{
  $sql = "SELECT `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` WHERE contest_id>=? AND contest_id <=? ORDER BY `contest_id` DESC";
  $result = pdo_query($sql,$pstart,$pend);
}
?>

<form action=contest_list.php class="center">
  <input name=keyword><input type=submit value="<?php echo $MSG_SEARCH?>">
</form>
<center>
  <table width=100% border=1 style="text-align:center;">
    <tr>
      <td>ID</td>
      <td>TITLE</td>
      <td>START</td>
      <td>END</td>
      <td>OPEN</td>
      <td>NOW</td>
      <td>EDIT</td>
      <td>COPY</td>
      <td>EXPORT</td>
      <td>LOGS</td>
      <td>SUSPECT</td>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr>";
      echo "<td>".$row['contest_id']."</td>";
      echo "<td><a href='../contest.php?cid=".$row['contest_id']."'>".$row['title']."</a></td>";
      echo "<td>".$row['start_time']."</td>";
      echo "<td>".$row['end_time']."</td>";
      $cid = $row['contest_id']."</td>";
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'."m$cid"])){
        echo "<td><a href=contest_pr_change.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['private']=="0"?"<span class=green>Public</span>":"<span class=red>Private<span>")."</a></td>";
        echo "<td><a href=contest_df_change.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class=green>Available</span>":"<span class=red>Reserved</span>")."</a></td>";
        echo "<td><a href=contest_edit.php?cid=".$row['contest_id'].">Edit</a></td>";
        echo "<td><a href=contest_add.php?cid=".$row['contest_id'].">Copy</a></td>";
    
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
          echo "<td><a href=\"problem_export_xml.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey']."\">Export</a></td>";
        }else{
          echo "<td></td>";
        }
        echo "<td> <a href=\"../export_contest_code.php?cid=".$row['contest_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey']."\">Logs</a></td>";
      }else{
        echo "<td colspan=5 align=right><a href=contest_add.php?cid=".$row['contest_id'].">Copy</a><td>";
      }
      echo "<td><a href='suspect_list.php?cid=".$row['contest_id']."'>Suspect</a></td>";
      echo "</tr>";
    }
  ?>
</table>
</center>
<div style="display:inline;">
  <nav class="center">
    <ul class="pagination pagination-sm">
      <li class="page-item"><a href="contest_list.php?page=1">&lt;&lt;</a></li>
      <?php
      if(!isset($page)) $page = 1;
      $page = intval($page);
      $section = 3;
      $start = $page>$section?$page-$section:1;
      $end = $page+$section>$cnt?$cnt:$page+$section;

      for($i=$start; $i<=$end; $i++){
        echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='contest_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
      }
      ?>
      <li class="page-item"><a href="contest_list.php?page=<?php echo $cnt?>">&gt;&gt;</a></li>
    </ul>
  </nav>
</div>
</div>

<?php require("../oj-footer.php");?>
