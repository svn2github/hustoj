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
                                    <li>用户设置</li>
                                    <li class="active">用户修改</li>
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
									<h4>用户修改</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
								    <?php 
								        if ($_POST['chsss'] == 'chsss') {
                                            require_once("../include/check_post_key.php");
								            $user_id = $_POST['user_id'];
								            $sql = 'SELECT * FROM `privilege` WHERE `user_id`=? AND `rightstr`=?';
								            if (count(pdo_query($sql, $user_id, 'administrator'))) {
								                $isadmin = 1;
								            }
								            else {
								                $isadmin = 0;
								            }
								            $sql = 'SELECT * FROM `users` WHERE `user_id`=?';
								            $result = pdo_query($sql, $user_id);
								            $row = $result[0];
								            $new_nick = $isadmin==0?$_POST['nick']:$row['nick'];
								            $new_email = $isadmin==0?$_POST['email']:$row['email'];
								            $new_school = $isadmin==0?$_POST['school']:$row['school'];
								            $sql = 'UPDATE `users` SET `nick`=?,`email`=?,`school`=? WHERE `user_id`=?';
								            pdo_query($sql, $new_nick, $new_email, $new_school, $user_id);
								            echo "修改成功!<script>history.back(-1);</script>";
								            if ($isadmin == 0) {
								                if (isset($_POST['password'])) {
								                    $passwd = $_POST['password'];
								                    if (get_magic_quotes_gpc ()) {
		$user_id = stripslashes ( $user_id);
		$passwd = stripslashes ( $passwd);
	}
	$passwd=pwGen($passwd);
	$sql="update `users` set `password`=? where `user_id`=?  and user_id not in( select user_id from privilege where rightstr='administrator') ";
	
	pdo_query($sql,$passwd,$user_id);
								                }
								            }
								        }
								    ?>
								    <?php 
								        $user_id = $_GET["user"];
								        $sql = "SELECT * FROM `users` WHERE `user_id`=?";
								        $row = pdo_query($sql, $user_id);
								        if (!count($row)) echo "用户不存在";
								        $result = $row[0];
								        $nick = $result['nick'];
								        $email = $result['email'];
								        $school = $result['school'];
								        $sql = 'SELECT * FROM `privilege` WHERE `user_id`=? AND `rightstr`=?';
								        if (count(pdo_query($sql, $user_id, 'administrator'))) {
								            $isadmin = 1;
								        }
								        else {
								            $isadmin = 0;
								        }
								    ?>
								    <form method="post">
								    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <?php require_once("../include/set_post_key.php");?>
                                <input type="hidden" name="chsss" value="chsss">
								    用户名: 
								    <input type="text" readonly="readonly" class="form-control" value="<?php echo $user_id;?>">
								    昵称：
								    <input type="text" class="form-control" name="nick" value="<?php echo $nick;?>"<?php if ($isadmin == 1) echo " readonly";?>>
								    密码：
								    <input type="text" class="form-control" name="password" placeholder="谨慎操作！请勿随意修改"<?php if ($isadmin == 1) echo " readonly";?>>
								    邮箱：
								    <input type="email" class="form-control" name="email" value="<?php echo htmlentities($email,ENT_QUOTES,"UTF-8")?>"<?php if ($isadmin == 1) echo " readonly";?>>
								    学校
								    <input type="text" class="form-control" name="nick" value="<?php echo $school;?>"<?php if ($isadmin == 1) echo " readonly";?>>
								    <button type="submit" class="btn btn-dark">提交</button>
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
