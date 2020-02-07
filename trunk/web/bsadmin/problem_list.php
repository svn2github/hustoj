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
                                    <li>题目</li>
                                    <li class="active">题目列表</li>
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
									<h4>题目列表</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php
$sql = "SELECT COUNT('problem_id') AS ids FROM `problem`";
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
  $sql = "SELECT `problem_id`,`title`,`accepted`,`in_date`,`defunct` FROM `problem` WHERE (problem_id LIKE ?) OR (title LIKE ?) OR (description LIKE ?) OR (source LIKE ?)";
  $result = pdo_query($sql,$keyword,$keyword,$keyword,$keyword);
}else{
  $sql = "SELECT `problem_id`,`title`,`accepted`,`in_date`,`defunct` FROM `problem` ORDER BY `problem_id` DESC LIMIT $sid, $idsperpage";
  $result = pdo_query($sql);
}
?>
                                        <form>
                                            <div class="form-group">
                                                <div class="input-group input-group-rounded col-md-4">
                                                    <input type="text" placeholder="键入以搜索" name=keyword class="form-control">
                                                    <span class="input-group-btn"><button class="btn btn-primary btn-group-right" type="submit"><i class="ti-search"></i></button></span>
                                                </div>
                                            </div>
                                        </form>
                                        <table width=100% style="text-align:center;" class="table table-hover">
  <form method=post action=contest_add.php>
    <tr>
        <td><input type=checkbox style='vertical-align:2px;' onchange='$("input[type=checkbox]").prop("checked", this.checked)'></td>
      <td width=60px>ID </td>
      <td>标题</td>
      <td>AC</td>
      <td>时间</td>
      <?php
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator']))
          echo "<td>状态</td><td>删除</td>";
        echo "<td>编辑</td><td>数据</td>";
      }
      ?>
    </tr>
    <?php
    foreach($result as $row){
      echo "<tr>";
        echo "<td><input type=checkbox style='vertical-align:2px;' name='pid[]' value='".$row['problem_id']."'></td>";
        echo "<td>".$row['problem_id']." </td>";
        echo "<td><a href='../problem.php?id=".$row['problem_id']."'>".$row['title']."</a></td>";
        echo "<td>".$row['accepted']."</td>";
        echo "<td>".$row['in_date']."</td>";
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'.'problem_editor'])){
          if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
            echo "<td><a href=problem_df_change.php?id=".$row['problem_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">".($row['defunct']=="N"?"<span titlc='click to reserve it' class='badge badge-success'>可用</span>":"<span class='badge badge-danger' title='click to be available'>不可用</span>")."</a><td>";
            if($OJ_SAE||function_exists("system")){
    ?>
              <a href=# onclick='javascript:if(confirm("Delete?")) location.href="problem_del.php?id=<?php echo $row['problem_id']?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>"'>删除</a>
        <?php
        }
      }
      if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||isset($_SESSION[$OJ_NAME.'_'."p".$row['problem_id']])){
        echo "<td><a href=problem_edit.php?id=".$row['problem_id']."&getkey=".$_SESSION[$OJ_NAME.'_'.'getkey'].">编辑</a>";
        echo "<td><a href='javascript:phpfm(".$row['problem_id'].");'>测试数据</a>";
      }
    }
    echo "</tr>";
  }
?>
    <tr>
      <td colspan=2 style="height:40px;">选中项</td>
      <td colspan=6>
        <!--input type=submit name='problem2contest' class="btn btn-info btn-outline" value='新竞赛'-->
        <button type=submit name='problem2contest' class="btn btn-info btn-outline">新竞赛</button>
        <!--input type=submit name='enable' value='可用' class="btn " onclick='$("form").attr("action","problem_df_change.php")'-->
        <button type=submit name='enable' class="btn btn-success btn-outline" onclick='$("form").attr("action","problem_df_change.php")'>可用</button>
        <!--input type=submit name='disable' value='不可用' onclick='$("form").attr("action","problem_df_change.php")'-->
        <button type=submit name='disable' class="btn btn-danger btn-outline" onclick='$("form").attr("action","problem_df_change.php")'>不可用</button>
      </td>
    </tr>
  </form>
</table>
<script>
function phpfm(pid){
  //alert(pid);
  $.post("phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
    if(status=="success"){
        var r = window.open("", "", "");
      r.document.location.href="phpfm.php?frame=3&pid="+pid;
    }
  });
}
</script>
<?php
if(!(isset($_GET['keyword']) && $_GET['keyword']!=""))
{
  echo "<ul class='pagination pagination-sm'>";
  echo "<li class='page-item'><a href='problem_list.php?page=".(strval(1))."'>&lt;&lt;</a></li>";
  echo "<li class='page-item'><a href='problem_list.php?page=".($page==1?strval(1):strval($page-1))."'>&lt;</a></li>";
  for($i=$spage; $i<=$epage; $i++){
    echo "<li class='".($page==$i?"active ":"")."page-item'><a title='go to page' href='problem_list.php?page=".$i.(isset($_GET['my'])?"&my":"")."'>".$i."</a></li>";
  }
  echo "<li class='page-item'><a href='problem_list.php?page=".($page==$pages?strval($page):strval($page+1))."'>&gt;</a></li>";
  echo "<li class='page-item'><a href='problem_list.php?page=".(strval($pages))."'>&gt;&gt;</a></li>";
  echo "</ul>";
}
?>
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