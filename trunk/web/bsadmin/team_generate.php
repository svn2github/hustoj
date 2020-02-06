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
                                    <li class="active">账号生成</li>
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
									<h4>账号生成</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
                                    <?php if(isset($_POST['prefix'])){
	require_once("../include/check_post_key.php");
	$prefix=$_POST['prefix'];
	require_once("../include/my_func.inc.php");
	if (!is_valid_user_name($prefix)){
		echo "Prefix is not valid.";
		exit(0);
	}
	$teamnumber=intval($_POST['teamnumber']);
        $pieces = explode("\n", trim($_POST['ulist']));
	
	if ($teamnumber>0){
		echo "<table class='table table-hover'>";
		echo "<tr><td colspan=3>账号列表(请复制)</td></tr>";
		echo "<tr><td>昵称<td>用户名</td><td>密码</td></tr>";
		for($i=1;$i<=$teamnumber;$i++){
			
        $user_id=$prefix.($i<10?('0'.$i):$i);
			$password=strtoupper(substr(MD5($user_id.rand(0,9999999)),0,10));
                        if(isset($pieces[$i-1]))
                        	$nick=$pieces[$i-1];
                        else
				$nick="可爱的OIer";
			if($teamnumber==1) $user_id=$prefix;

			echo "<tr><td>$nick<td>$user_id</td><td>$password</td></tr>";
			
			$password=pwGen($password);
			$email="a@b";
                       
			$school="我是可爱的OIer";
			$ip = ($_SERVER['REMOTE_ADDR']);
			if( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ){
			    $REMOTE_ADDR = $_SERVER['HTTP_X_FORWARDED_FOR'];
			    $tmp_ip=explode(',',$REMOTE_ADDR);
			    $ip =(htmlentities($tmp_ip[0],ENT_QUOTES,"UTF-8"));
			}
			$sql="INSERT INTO `users`("."`user_id`,`email`,`ip`,`accesstime`,`password`,`reg_time`,`nick`,`school`)".
			"VALUES(?,?,?,NOW(),?,NOW(),?,?)on DUPLICATE KEY UPDATE `email`=?,`ip`=?,`accesstime`=NOW(),`password`=?,`reg_time`=now(),nick=?,`school`=?, `qq`=?, `backimg`=?, `codeshare`=?, `mailok`=?";
			pdo_query($sql,$user_id,$email,$ip,$password,$nick,$school,$email,$ip,$password,$nick,$school,'12345678', './template/meto/1.jpg', 'Y', '0') ;
		}
		echo  "</table>";
		
		
	}
	
}
?>
                                <form action='team_generate.php' method=post class="form">
	    <label style="width:100px">账号前缀</label><input type='test' name='prefix' value='moj_' placeholder="moj_" class="form-control" style="display:inline;width:60%"><br>
	    <label style="width:100px">创建</label><input type=input name='teamnumber' class="form-control" style="display:inline;width:30%" value=5 size=3>个账号<br>
        <label style="width:100px">昵称</label><textarea class="form-control" style="display:inline;width:60%" name="ulist" rows="12" cols="40" placeholder="预先设置昵称，一行一个"></textarea><br></bt>
		<?php require_once("../include/set_post_key.php");?>
		<button type="submit" class="btn btn-dark">创建</button>
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