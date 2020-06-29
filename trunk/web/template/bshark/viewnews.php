<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_NEWS;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
            <div class="col-md-8">
                <div class="card">
  <div class="card-body">
    <h4><?php echo $MSG_NEWS;?> - <?php echo $news_title;?></h4>
    <?php echo $news_content;?>
    </div>
    </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4><?php echo $MSG_NEWS;?></h4>
                <p><?php echo $MSG_USER;?>：<?php echo $news_writer;?><br>
                <?php echo $MSG_SUBMIT_TIME;?>：<?php echo $news_date;?></p>
            </div>
        </div>
    </div>
</div>
<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
