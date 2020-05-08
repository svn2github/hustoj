<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Styles -->
	<?php require("./header-files.php");
	require_once("../include/my_func.inc.php");
	
  require_once("../include/const.inc.php");
include_once("kindeditor.php");
?>
    <title><?php echo $OJ_NAME;?> - Admin</title>


</head>

<body>

    <?php require("./nav.php");?>
    <?php 
    if ($mod=='hacker') {
        header("Location:index.php");
    }
    
require_once("../include/set_get_key.php");
?>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>后台主页</h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li>常规设置</li>
                                    <li class="active">新闻列表</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
					<div class="row"> 
						<div class="col-lg-12">
							<div class="card alert">
								<div class="card-header">
									<h4>新闻列表</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php
$sql = "SELECT COUNT('news_id') AS ids FROM `news`";
$result = pdo_query($sql);
$row = $result[0];

$ids = intval($row['ids']);

$idsperpage = 25;
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
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` WHERE (title LIKE ?) OR (content LIKE ?) ORDER BY `news_id` DESC";
  $result = pdo_query($sql,$keyword,$keyword);
}else{
  $sql = "SELECT `news_id`,`user_id`,`title`,`time`,`defunct` FROM `news` ORDER BY `news_id` DESC LIMIT $sid, $idsperpage";
  $result = pdo_query($sql);
}
?>
<div class="basic-form">
                                        <form>
                                            <div class="form-group">
                                                <div class="input-group input-group-rounded col-md-4">
                                                    <input type="text" placeholder="键入以搜索" name=keyword class="form-control">
                                                    <span class="input-group-btn"><button class="btn btn-primary btn-group-right" type="submit"><i class="ti-search"></i></button></span>
                                                </div>
                                            </div>
                                        </form>
                                        <table width=100% style="text-align:center;" class="table table-hover">
    <tr style='height:22px;'>
      <td>ID</td>
      <td>标题</td>
      <td>更新时间</td>
      <td>状态</td>
      <td>复制</td>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr style='height:22px;'>";
        echo "<td><a href='news_edit.php?id=".$row['news_id']."'>".$row['news_id']."</a></td>";
        echo "<td><a href='news_edit.php?id=".$row['news_id']."'>".$row['title']."</a>"."</td>";
        echo "<td>".$row['time']."</td>";
        echo "<td><a href=news_df_change.php?id=".$row['news_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span class='badge badge-success'>可用</span>":"<span class='badge badge-danger'>不可用</span>")."</a>"."</td>";
        echo "<td><a href=news_add_page.php?cid=".$row['news_id'].">复制</a></td>";
      echo "</tr>";
    }
    ?>
    </form>
  </table>
  <?php
if(!(isset($_GET['keyword']) && $_GET['keyword']!=""))
{
  echo "<ul class='pagination pagination-sm'>";
  echo "<li class='page-item'><a href='news_list.php?page=".(strval(1))."'>&lt;&lt;</a></li>";
  echo "<li class='page-item'><a href='news_list.php?page=".($page==1?strval(1):strval($page-1))."'>&lt;</a></li>";
  for($i=$spage; $i<=$epage; $i++){
    echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='news_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
  }
  echo "<li class='page-item'><a href='news_list.php?page=".($page==$pages?strval($page):strval($page+1))."'>&gt;</a></li>";
  echo "<li class='page-item'><a href='news_list.php?page=".(strval($pages))."'>&gt;&gt;</a></li>";
  echo "</ul>";
}
?>
                                    </div>
								</div>
							</div>
						</div>
                    </div><!-- /# row -->
					 </div>
     <!-- /# main content -->
     CopyRight &copy; 1999-<?php echo date('Y');?> MasterOJ.All rights reserved
            </div><!-- /# container-fluid -->
        </div><!-- /# main -->
    </div><!-- /# content wrap -->
	
	
	
    <script src="assets/js/lib/jquery.min.js"></script><!-- jquery vendor -->
    <script src="assets/js/lib/jquery.nanoscroller.min.js"></script><!-- nano scroller -->    
    <script src="assets/js/lib/sidebar.js"></script><!-- sidebar -->
    <script src="assets/js/lib/bootstrap.min.js"></script><!-- bootstrap -->
    <script src="assets/js/lib/mmc-common.js"></script>
    <script src="assets/js/lib/mmc-chat.js"></script>
	<!--  Chart js -->
	<script src="assets/js/lib/chart-js/Chart.bundle.js"></script>
	<script src="assets/js/lib/chart-js/chartjs-init.js"></script>
	<!-- // Chart js -->


    <script src="assets/js/lib/sparklinechart/jquery.sparkline.min.js"></script><!-- scripit init-->
    <script src="assets/js/lib/sparklinechart/sparkline.init.js"></script><!-- scripit init-->
	
	<!--  Datamap -->
    <script src="assets/js/lib/datamap/d3.min.js"></script>
    <script src="assets/js/lib/datamap/topojson.js"></script>
    <script src="assets/js/lib/datamap/datamaps.world.min.js"></script>
    <script src="assets/js/lib/datamap/datamap-init.js"></script>
	<!-- // Datamap -->-->
    <script src="assets/js/lib/weather/jquery.simpleWeather.min.js"></script>	
    <script src="assets/js/lib/weather/weather-init.js"></script>
    <script src="assets/js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="assets/js/lib/owl-carousel/owl.carousel-init.js"></script>
    <script src="assets/js/scripts.js"></script><!-- scripit init-->
</body>
</html>