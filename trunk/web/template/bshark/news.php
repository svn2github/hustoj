<?php
$sql = 'SELECT * FROM `news` WHERE `defunct`!=\'Y\' ORDER BY `importance`';
$news = pdo_query($sql);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>公告 - MasterOJ</title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
            <div class="col-md-8">
            <div class="card">
  <div class="card-body">
    <h4>公告列表</h4>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>公告标题</th>
        <th>上传时间</th>
        <th>作者</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($news as $view_news) {
          ?><tr><td><a href="viewnews.php?id=<?php echo $view_news['news_id'];?>"><?php echo $view_news['title'];?></a></td><td><?php echo $view_news['time'];?></td><td><?php echo $view_news['user_id'];?></td></tr><?php
      }
      ?>
    </tbody>
</table>
</div>
</div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4>检索</h4>
            </div>
        </div>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
