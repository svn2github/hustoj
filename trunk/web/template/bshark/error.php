<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Error - MasterOJ</title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="card" style="margin: 3% 8% 5% 8%">
  <div class="card-body">
    <h4>访问错误！</h4>
    <?php 
    function GetCurUrl() {
    return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
}
    ?>
    <p>请求地址:<?php echo GetCurUrl();?><br>错误信息:<?php echo $view_errors;?></p>
    <hr/>
    <div class="btn-group">
        <button class="btn btn-outline-info" onclick="location.href='/index.php'">主页</button>
        <button class="btn btn-outline-success" onclick="history.back(-1)">返回上一页</button>
    </div>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
