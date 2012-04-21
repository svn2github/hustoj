<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0093)file:///D:/360data/%E9%87%8D%E8%A6%81%E6%95%B0%E6%8D%AE/%E6%A1%8C%E9%9D%A2/MyAdmin2/index.htm -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>特征管理</title>
<!--                       CSS                       -->
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="./resources/reset.css" type="text/css" media="screen"/>
<!-- Main Stylesheet -->
<link rel="stylesheet" href="./resources/style.css" type="text/css" media="screen"/>
<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
<link rel="stylesheet" href="./resources/invalid.css" type="text/css" media="screen"/>
<!--                       Javascripts                       -->
<!-- jQuery -->
<script type="text/javascript" src="./resources/jquery-1.3.2.min.js"></script>
<!-- jQuery Configuration -->
<script type="text/javascript" src="./resources/simpla.jquery.configuration.js"></script>
<!-- Main js -->
<script type="text/javascript" src="./resources/common.js"></script>
</head>
<body>
<div id="body-wrapper">
	
	<!-- Main Content Section with everything -->
	<div id="main-content">
		
		<!-- Page Head -->
		<h2>特征管理</h2>
		<div class="clear"></div>
		<!-- End .clear -->
		
		<div class="content-box">
			<!-- Start Content Box -->
			<div class="content-box-header">
				<h3 style="cursor: s-resize; ">特征列表</h3>
				<div class="clear"></div>
			</div>
			<!-- End .content-box-header -->
			<div class="content-box-content">
				<div class="tab-content default-tab" id="tab1" style="display: block; ">
					<!-- This is the target div. id must match the href of this div's tab -->
					<?php
                        require_once 'define.php';
                        require_once 'mysql.php';
                        require_once 'FunctionBase.php';
                        
                        $mysql = MySql::getInstance();
                        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
                        if($action=='del' && isset($_REQUEST['id']))
                        {
                            $id = $_REQUEST['id'];
                            $mysql->query("delete from ErrFeature where id='".$id."';");
                            emDirect("FeatureList.php?active_del=true");
                        }
                        $rq = $mysql->query('select * from ErrFeature');
                       
                        
                    ?>
					<table>
						<thead>
							<tr>
								<th>ID</th>
                                <th>类型</th>
                                <th>特征表达式</th>
								<th>提示信息</th>
								<th>操作</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="6">
									<div class="bulk-actions align-left">
										<a class="button" href="AddFeature.php">添加</a>
										<a class="button" href="javascript: window.location = 'TestFeature.php';">测试</a>
									</div>
									<div class="clear"></div>
								</td>
							</tr>
						</tfoot>
						<tbody>
                        <?php
                        $i = 0;
                        while($ar = $mysql->fetch_array($rq))
                        {
                            $i++;
                            if($i%2)
                            {
                                echo '<tr class="alt-row">';
                            }
                            else
                            {
                                echo '<tr>';
                            }
                        ?>
								<td>
									<?= $ar['id']?>
								</td>
                                <td>
                                    <?php echo $tbErrKind[$ar['type']]?>
								</td>
								<td>
                                    <?= $ar['regex']?>
								</td>
								<td>
									 <?= $ar['info']?>
								</td>
								<td>
									<a href="EditFeature.php?id=<?php echo $ar['id'] ?>" title="Edit">
									<img src="./resources/pencil.png" alt="Edit"/>
									</a>
									<a href="javascript: em_confirm(<?php echo $ar['id'] ?>, 'feature');" title="Delete">
									<img src="./resources/cross.png" alt="Delete"/>
									</a>
								</td>
							</tr>
                        <?php }?>
						</tbody>
					</table>
				</div>
				<!-- End #tab1 -->
			</div>
			<!-- End .content-box-content -->
		</div>
		<div class="clear"></div>
		
		<!-- End #footer -->
	</div>
	<!-- End #main-content -->
</div>
</body>
</html>