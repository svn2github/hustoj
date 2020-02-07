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
                                    <li>用户设置</li>
                                    <li class="active">添加权限</li>
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
									<h4>添加权限</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php 
								    if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	$user_id=$_POST['user_id'];
	$rightstr =$_POST['rightstr'];
	if(isset($_POST['contest'])) $rightstr="c$rightstr";
	if(isset($_POST['psv'])) $rightstr="s$rightstr";
	$sql="insert into `privilege` values(?,?,'N')";
	$rows=pdo_query($sql,$user_id,$rightstr);
	echo "$user_id $rightstr added!";
	
}
?>
                            <form method=post>
<?php require("../include/set_post_key.php");?>
	<b>给用户添加全站权限</b><br />
	用户名<input type=text class="form-control" size=10 name="user_id"><br />
	权限
	<select name="rightstr"class="form-control" >
<?php
$rightarray=array("administrator","problem_editor","source_browser","contest_creator","http_judge","password_setter","printer","balloon" );
while(list($key, $val)=each($rightarray)) {
	if (isset($rightstr) && ($rightstr == $val)) {
		echo '<option value="'.$val.'" selected>'.$val.'</option>';
	} else {
		echo '<option value="'.$val.'">'.$val.'</option>';
	}
}
?></select><br />
	<input type='hidden' name='do' value='do'>
	<button type="submit" class="btn btn-primary">提交</button>
</form>
<hr/>
<form method=post>
	<b>给用户添加竞赛权限</b><br />
	用户名<input type=text size=10 class="form-control" name="user_id"><br />
	竞赛编号<input type=text size=10 class="form-control" name="rightstr">
	<input type='hidden' name='do' value='do'>
	<input type='hidden' name='contest' value='do'>
	<button type="submit" class="btn btn-primary">提交</button>
	<input type=hidden name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey']?>">
</form>
<hr/>
<form method=post>
	<b>给用户添加题目提交查看权限</b><br />
	用户名<input type=text size=10 class="form-control" name="user_id"><br />
	题目编号<input type=text size=10 class="form-control" name="rightstr"><br />
	<input type='hidden' name='do' value='do'>
	<input type='hidden' name='psv' value='do'>
	<button type="submit" class="btn btn-primary">提交</button>
	<input type=hidden name="postkey" value="<?php echo $_SESSION[$OJ_NAME.'_'.'postkey']?>">
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