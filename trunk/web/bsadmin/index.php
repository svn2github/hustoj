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
    <?php if ($mod != 'hacker') { ?>
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
                                    <li class="active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
					<div class="row"> 
						<div class="col-lg-9">
							<div class="card alert">
								<div class="card-header">
									<h4>最近一周提交记录</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="sales-chart">
									<canvas id="myChart"></canvas>
								</div>
							</div>
						</div><!-- /# column -->
                        <div class="col-lg-3">
                            <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>用户个数</h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php 
                                    echo count(pdo_query("SELECT * FROM `users`"));
                                    ?>
                                </div>
                            </div>

                            <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>评测次数</h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash3"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php 
                                    echo count(pdo_query("SELECT * FROM `solution`"));
                                    ?>
                                </div>
                            </div>
                            <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>题目个数</h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash4"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php 
                                    echo count(pdo_query("SELECT * FROM `problem`"));
                                    ?>
                                </div>
                            </div> 
                            <div class="card alert nestable-cart single-card">
                                <div class="card-header">
                                    <h4>竞赛个数</h4> 
                                </div>
                                <div class="sparkline-box">
                                    <span id="sparklinedash2"><canvas width="67" height="30" style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas></span>
                                </div>
                                <div class="visit-count">
                                    <?php 
                                    echo count(pdo_query("SELECT * FROM `contest`"));
                                    ?>
                                </div>
                            </div> 

                        </div>
                    </div><!-- /# row -->
						<div class="col-lg-4">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>DEMOS</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="recent-meaasge">
									<div class="media">
										<div class="media-body">
											<h5 class="media-heading">Hustoj兼容版</h5>
											<div class="meaasge-date"></div>
											<p>包含普通Hustoj的所有内容，配bshark主题和bsadmin后台</p>
										</div>
									</div>
									<div class="media">
										<div class="media-body">
											<h5 class="media-heading">VegeTableOJ</h5>
											<div class="meaasge-date"></div>
											<p>自主研发，包含更多丰富内容</p>
										</div>
									</div>
								</div>
							</div><!-- /# card -->
						</div><!-- /# column -->
						<div class="col-lg-4">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>开发人员</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="recent-meaasge">
									<div class="media">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1440169768&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">Yemaster</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
									<div class="media">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1014763456&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">HP:)</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
									<div class="media no-border">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1257749706&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">野心</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
								</div>
							</div><!-- /# card -->
						</div><!-- /# column -->
						<div class="col-lg-4">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>时间线</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"><i class="fa fa-smile-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">BShark主题诞生</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2019年8月1日</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="timeline-badge warning"><i class="fa fa-user-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">BSadmin诞生</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2019年10月23日</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="timeline-badge success"><i class="fa fa-check-circle-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">BShark系列开源</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2020年2月10日</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
					</div><!-- /# row -->     </div>
     <!-- /# main content -->
     CopyRight &copy; 1999-<?php echo date('Y');?> MasterOJ.All rights reserved
            </div><!-- /# container-fluid -->
        </div><!-- /# main -->
    </div><!-- /# content wrap -->
    
    <?php } else { ?><div class="content-wrap">
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
                                    <li class="active">Home</li>
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
									<h4>欢迎您！Hacker!</h4>
									<div class="card-header-right-icon">
										<ul>
											<li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
										</ul>
									</div>
								</div>
								<div class="card-body">
									<p>欢迎您的到来。Hacker！</p>
									<p>想必破解这个后台地址一定费了不少劲吧！</p>
									<p>系统已经自动记录下了您的信息！</p>
									<p>
									    您的代理信息：<?php 
                                            echo $_SERVER['HTTP_USER_AGENT'];
									    ?><br>
									    您的ip地址：<?php echo $_SERVER["REMOTE_ADDR"];?><br>
									    以这个ip注册的用户有：<?php 
									        $youip = $_SERVER["REMOTE_ADDR"];
									        foreach(pdo_query("SELECT * FROM `users` WHERE `ip`=?",$youip) as $ross) {
									            echo $ross['user_id'].',';
									        }
									    ?><br>
									    以这个ip登陆过的用户有：<?php 
									        $isrecord=Array();
									        $youip = $_SERVER["REMOTE_ADDR"];
									        foreach(pdo_query("SELECT * FROM `loginlog` WHERE `ip`=?",$youip) as $ross) {
									            if ($isrecord[$ross['user_id']] != '2333') echo $ross['user_id'].',';
									            $isrecord[$ross['user_id']] = '2333';
									        }
									    ?><br>
									</p>
								</div>
							</div>
						</div>
                    </div><!-- /# row -->
					<div class="row">
						<div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>开发人员</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="recent-meaasge">
									<div class="media">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1440169768&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">Yemaster</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
									<div class="media">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1014763456&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">HP:)</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
									<div class="media no-border">
										<div class="media-left">
											<a href="#"><img class="media-object" src="http://q.qlogo.cn/headimg_dl?dst_uin=1257749706&spec=160" width=50 height=50 alt="..."></a>
										</div>
										<div class="media-body">
											<h5 class="media-heading">野心</h5>
											<div class="meaasge-date"></div>
											<p>主要开发人员</p>
										</div>
									</div>
								</div>
							</div><!-- /# card -->
						</div><!-- /# column -->
						<div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>时间线</h4>
                                    <div class="card-header-right-icon">
                                        <ul>
                                            <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li> 
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"><i class="fa fa-smile-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">OJ诞生</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2019年2月13日</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="timeline-badge warning"><i class="fa fa-user-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">用户人数达到180</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2019年7月23日</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="timeline-badge success"><i class="fa fa-check-circle-o"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h5 class="timeline-title">采用自主的Bshark主题</h5>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>2019年8月1日</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /# card -->
                        </div>
					</div><!-- /# row -->     </div>
     <!-- /# main content -->
     CopyRight &copy; 1999-<?php echo date('Y');?> MasterOJ.All rights reserved
            </div><!-- /# container-fluid -->
        </div><!-- /# main -->
    </div><!-- /# content wrap -->
    <?php } ?>
	
	
	
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
    <script>
        
<?php 
$day[1] = strtotime(date('Y-m-d',time()));
$day[0] = $day[1] + 60*60*24;
$day[2] = $day[1] - 60*60*24;
$day[3] = $day[2] - 60*60*24;
$day[4] = $day[3] - 60*60*24;
$day[5] = $day[4] - 60*60*24;
$day[6] = $day[5] - 60*60*24;
$day[7] = $day[6] - 60*60*24;
$sql ='SELECT * FROM `solution` WHERE UNIX_TIMESTAMP(`in_date`)>=? AND UNIX_TIMESTAMP(`in_date`)<?';
for ($csadff = 1; $csadff <= 7; ++$csadff) {
    $subcount[$csadff] = count(pdo_query($sql, $day[$csadff], $day[$csadff - 1]));
    $account[$csadff] = count(pdo_query($sql.' AND `result`=4', $day[$csadff], $day[$csadff - 1]));
}
?>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php for ($i =1 ; $i <= 7; ++$i) {
            echo '\''.date('Y-m-d', $day[8-$i]).'\'';
            if ($i != 7) echo ',';
        }
            ?>],
        datasets: [{
            label: '提交',
            data: [<?php for ($i =1 ; $i <= 7; ++$i) {
            echo $subcount[8-$i];
            if ($i != 7) echo ',';
        }
            ?>],
            backgroundColor: '#2185d0',
            borderColor: '#2185d0',
            borderWidth: 1
        },
        {
            label: '正确',
            data: [<?php for ($i =1 ; $i <= 7; ++$i) {
            echo $account[8-$i];
            if ($i != 7) echo ',';
        }
            ?>],
            backgroundColor: '#4caf50',
            borderColor: '#4caf50',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
    </script>
</body>
</html>
