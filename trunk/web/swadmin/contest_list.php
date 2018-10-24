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

<title>Contest List</title>
<hr>
<center><h3><?php echo $MSG_CONTEST.$MSG_LIST?></h3></center>

<div class='container'>

<?php
$sql = "SELECT COUNT('contest_id') AS ids FROM `contest`";
$result = pdo_query($sql);
$row = $result[0];

$ids = intval($row['ids']);

$idsperpage = 10;
$pages = intval(ceil($ids/$idsperpage));

if(isset($_GET['page'])){ $page = intval($_GET['page']);}
else{ $page = 1;}

$pagesperframe = 5;
$frame = intval(ceil($page/$pagesperframe));

$spage = ($frame-1)*$pagesperframe+1;
$epage = min($spage+$pagesperframe-1, $pages);

$sid = ($page-1)*$idsperpage;

$sql = "";
if(isset($_GET['keyword']) && $_GET['keyword']!=""){
  $keyword = $_GET['keyword'];
  $keyword = "%$keyword%";
  $sql = "SELECT `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` WHERE (title LIKE ?) OR (description LIKE ?) ORDER BY `contest_id` DESC";
  $result = pdo_query($sql,$keyword,$keyword);
}else{
  $sql = "SELECT `contest_id`,`title`,`start_time`,`end_time`,`private`,`defunct` FROM `contest` ORDER BY `contest_id` DESC LIMIT $sid, $idsperpage";
  $result = pdo_query($sql);
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
      $cid = $row['contest_id'];
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

<?php
if(!(isset($_GET['keyword']) && $_GET['keyword']!=""))
{
  echo "<div style='display:inline;'>";
  echo "<nav class='center'>";
  echo "<ul class='pagination pagination-sm'>";
  echo "<li class='page-item'><a href='contest_list.php?page=".(strval(1))."'>&lt;&lt;</a></li>";
  echo "<li class='page-item'><a href='contest_list.php?page=".($page==1?strval(1):strval($page-1))."'>&lt;</a></li>";
  for($i=$spage; $i<=$epage; $i++){
    echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='contest_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
  }
  echo "<li class='page-item'><a href='contest_list.php?page=".($page==$pages?strval($page):strval($page+1))."'>&gt;</a></li>";
  echo "<li class='page-item'><a href='contest_list.php?page=".(strval($pages))."'>&gt;&gt;</a></li>";
  echo "</ul>";
  echo "</nav>";
  echo "</div>";
}
?>

</div>
