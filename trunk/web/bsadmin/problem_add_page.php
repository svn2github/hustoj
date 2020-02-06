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
                                    <li>问题</li>
                                    <li class="active">新建问题</li>
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
									<h4>新建问题</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
  <form action=problem_add.php method='post'>
    <?php require_once("../include/set_post_key.php");?>
      <input type=hidden name=problem_id value="New Problem">
    <label for=title>标题</label><input type="text" name="title" class="form-control" value="">
    <label for=limit>时空限制</label>
    <div><input type="number" name="time_limit" class="form-control" style="width:40%;display:inline" size=20 value="1">秒
    <input type="number" name="memory_limit" class="form-control" style="width:40%;display:inline" size=20 value="128">MB</div>
    <lable for=description>题目描述</lable>
    <textarea name='description' rows=15 class="kindeditor" ></textarea><br>
    <lable for=input>输入格式</lable>
    <textarea name='input' rows=15 class="kindeditor" ></textarea><br>
    <lable for=output>输出格式</lable>
    <textarea name='output' rows=15 class="kindeditor" ></textarea><br>
    <lable for=sample_input>样例输入</lable>
    <textarea name='sample_input' rows=15 class='form-control' ></textarea><br>
    <lable for=sample_output>样例输出</lable>
    <textarea name='sample_output' rows=15 class='form-control' ></textarea><br>
    <lable for=hint>提示</lable>
    <textarea name='hint' rows=15 class="kindeditor" ><p></p>
        </textarea><br>
    <lable for=source>来源</lable>
    <textarea name='source' rows=1 class="form-control"></textarea><br>
     <label for=spj>Special Judge：</label>
          <?php echo "No "?><input type=radio name=spj value='0'  checked><?php echo "/ Yes "?><input type=radio name=spj value='1'><br><br>
    <?php echo "<label for=contest_id>竞赛&作业</label>"?>
          <select name=contest_id class="form-control">
            <?php
            $sql="SELECT `contest_id`,`title` FROM `contest` WHERE `start_time`>NOW() order by `contest_id`";
            $result=pdo_query($sql);
            echo "<option value=''>暂无竞赛</option>";
            if (count($result)==0){
            }else{
              foreach($result as $row){
                echo "<option value='{$row['contest_id']}'>{$row['contest_id']} {$row['title']}</option>";
              }
            }?>
          </select><br>
    <button type='submit' class="btn btn-info btn-addon i"><i class="fa fa-plus"></i>新建</button>
  </form>
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