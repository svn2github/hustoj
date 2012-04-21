<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
<title>特征管理</title>

<!--                       CSS                       -->

<!-- Reset Stylesheet -->
<link rel="stylesheet" href="./resources/reset.css" type="text/css" media="screen">

<!-- Main Stylesheet -->
<link rel="stylesheet" href="./resources/style.css" type="text/css" media="screen">

<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
<link rel="stylesheet" href="./resources/invalid.css" type="text/css" media="screen">

<!--                       Javascripts                       -->
<!-- jQuery -->
<script type="text/javascript" src="./resources/jquery-1.3.2.min.js"></script>

<!-- jQuery Configuration -->
<script type="text/javascript" src="./resources/simpla.jquery.configuration.js"></script>
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
				<h3 style="cursor: s-resize; ">测试特征</h3>
				<div class="clear"></div>
			</div>
			<!-- End .content-box-header -->
			<div class="content-box-content">
            <?php
            require_once 'mysql.php';
            $err = isset($_REQUEST['err']) ? $_REQUEST['err']:'';
            $type = isset($_REQUEST['type']) ? $_REQUEST['type']:'';
            if($err!='')
            {
                
                $mysql = MySql::getInstance();
                $sql = 'select * from ErrFeature';
                $rq = $mysql->query($sql);
                $matchs = array();
                while($ar = $mysql->fetch_array($rq))
                {
                    if(preg_match_all($ar['regex'], $err, $matchs, PREG_SET_ORDER))
                    {
                        foreach($matchs as $m)
                        {
                            echo "行".$m[1].": ".$ar['info']."<br />";
                        }
                    }
                }
            }        
            ?>
				<form action="TestFeature.php?action=update" method="get">
					<fieldset>
						<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
						<p>
							<label>类型</label>
                            <select name="type">
                                <?php 
                                require_once 'define.php';
                                foreach($tbErrKind as $id=>$key)
                                {
                                    if($type==$id)
                                    {
                                ?>
                                <option selected value="<?php echo $id?>"><?php echo $key?></option>
                                <?php
                                }
                                else{
                                ?>
                                <option value="<?php echo $id?>"><?php echo $key?></option>
                                <?php }} ?>
                            </select>				
                        </p>
						<p>
							<label>程序错误信息</label>
                            <textarea name="err" rows="10"><?php echo $err?></textarea>
						</p>
                        <p>
						</p>
						<p>
							<input class="button" type="submit" value="提交" />
                            <input class="button" type="button" value="返回" onclick="javascript: window.location='FeatureList.php';" />
						</p>
					</fieldset>
					<div class="clear"></div>
					<!-- End .clear -->
				</form>
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