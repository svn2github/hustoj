<?php
if ($THEME_HOME_STATISTICS == "show") {
$sql='SELECT COUNT(1) FROM `problem`';
$result=pdo_query($sql);
$problem_count=$result[0][0];
$sql='SELECT COUNT(1) FROM `users`';
$result=pdo_query($sql);
$user_count=$result[0][0];
$sql='SELECT COUNT(1) FROM `solution`';
$result=pdo_query($sql);                     
$submit_count=$result[0][0];
$sql='SELECT solved FROM `users` WHERE `user_id`=?';
$result=pdo_query($sql,$_SESSION[$OJ_NAME.'_'.'user_id']);
$ac_count=$result[0]['solved'];                
$sql='SELECT * FROM `news` WHERE `importance`<0 AND `defunct`!="Y"'; 
$result=pdo_query($sql);                    
$res=$result;
    $day[1] = strtotime(date('Y-m-d',time()));  
    $day[0] = $day[1] + 60*60*24;               
    $day[2] = $day[1] - 60*60*24;               
    $day[3] = $day[2] - 60*60*24;               
    $day[4] = $day[3] - 60*60*24;               
    $day[5] = $day[4] - 60*60*24;               
    $day[6] = $day[5] - 60*60*24;               
    $day[7] = $day[6] - 60*60*24;               
    $sql ='SELECT COUNT(1) FROM `solution` WHERE UNIX_TIMESTAMP(`in_date`)>=? AND UNIX_TIMESTAMP(`in_date`)<?';
    for ($csadff = 1; $csadff <= 7; ++$csadff) { 
        $subcount[$csadff] = pdo_query($sql, $day[$csadff], $day[$csadff - 1])[0][0];
        $account[$csadff] = pdo_query($sql.' AND `result`=4', $day[$csadff], $day[$csadff - 1])[0][0];
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $MSG_HOME;?> - <?php echo $OJ_NAME;?></title>
        <?php require("./template/bshark/header-files.php");?>
        <style>
            .faqs-card {
                border-radius: 20px;
                border: 1px solid #00000020;
                padding: 20px;
                margin-bottom: 10px;
            }
        </style>
    </head>
    
    <body>
        <?php require("./template/bshark/nav.php");?>
        <div class="row" style="margin: 3% 8% 5% 8%">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <?php
$sql = 'SELECT * FROM `news` WHERE `defunct`!=\'Y\' ORDER BY `importance`';
$news = pdo_query($sql);
?>                
<h4><?php echo $MSG_NEWS;?></h4>
<?php if ($THEME_NEWS_MOD == 'list') { ?>
<table class="table table-hover">
    <thead>
      <tr>
        <th><?php echo $MSG_NEWS.$MSG_TITLE;?></th>
        <th><?php echo $MSG_SUBMIT_TIME;?></th>
        <th><?php echo $MSG_USER;?></th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($news as $view_news) {
          ?><tr><td><a href="viewnews.php?id=<?php echo $view_news['news_id'];?>"><?php echo $view_news['title'];?></a></td><td><?php echo $view_news['time'];?></td><td><?php echo $view_news['user_id'];?></td></tr><?php
      }
      ?>
    </tbody>
</table>
    <?php }  else if ($THEME_NEWS_MOD == 'show') {
        foreach ($news as $view_news) {
            ?>
            <div class="faqs-card">
<h4><?php echo $view_news['title'];?> <small><?php echo $view_news['user_id'];?> - <?php echo $view_news['time'];?></small></h4>
<?php echo $view_news['content'];?>
            </div>
            <?php
        }
    } else echo "There is something wrong with your configuration file.Please open '/template/bshark/theme.conf.php' and fix it." ?>
                    </div>
                </div>
<br>
    <?php if ($THEME_HOME_STATISTICS == "show") { ?>
                <div class="card"><div class="card-body">
    <h4>统计信息</h4>
    <p>共有<?php
echo $user_count;
?>位大佬入驻OJ,共有<?php
echo $problem_count;
?>道优质题目,我已完成<?php echo $ac_count;?>道,评测机已完成<?php echo $submit_count;?>次评测,欢迎新用户:
<?php
echo pdo_query('select * from `users` order by `reg_time` DESC limit 1')[0]['user_id'];
?>!</p>
<div>
<div style="width:100%;" align="center">

<canvas id="myChart"></canvas>
</div></div>
</div></div><br>
<?php } ?>
<div class="card"><div class="card-body">
    <h4>关于<?php echo $OJ_NAME;?></h4>
    <p>This ACM/ICPC OnlineJudge is a GPL product from hustoj<br>hustoj -- 流行的开源OJ系统，含*.deb安装包和Win集成版。<br>本OJ基于Hustoj，采用BShark主题，BShark主题由<a href="http://github.com/yemaster">yemaster</a>开发<br>
	    <a href="https://github.com/zhblue/hustoj">请到GitHub来给我们加star!</a><br>
    </p>
    </div></div>
<?php if ($THEME_AUTO_GET_LATEST_INFO == "yes") { ?>
<br>
<div class="card">
    <div class="card-body">
        <h4>当前版本：Bshark <?php echo $THEME_BSHARK_VERSION;?></h4>
        <div id="info-version"></div>
    </div>
</div>
<?php } ?>
    </div>
    
            <div class="col-md-4"><div class="card"><div class="card-body">
    <h4><?php echo $MSG_SEARCH;?><?php echo $MSG_PROBLEM;?></h4>
							<form action='problemset.php' class="form-search form-inline">
							        <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-search"></i></span>
        </div>
								<input type="text" name=search class="form-control search-query" style="display:inline;width:auto">
								</div>
							</form>
    </div>
        </div>
                <br><div class="card"><div class="card-body">
    <h4><?php echo $MSG_CONTEST;?></h4>
    <?php 
    $sql = "SELECT * FROM `contest` WHERE `defunct`!='Y' ORDER BY UNIX_TIMESTAMP(`start_time`) DESC LIMIT 5";
    $ress = pdo_query($sql);
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="auto"><?php echo $MSG_TITLE;?></th>
                <th width="auto"><?php echo $MSG_STATUS;?></th>
                <th width="auto"><?php echo $MSG_START_TIME;?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ress as $new) { ?>
            <tr>
                <td><a href="contest.php?cid=<?php echo $new['contest_id'];?>"><?php echo $new['title'];?></a></td> 
                <td><?php if (strtotime($new['end_time'])<time()) { ?><span class="badge badge-secondary"><?php echo $MSG_Ended;?></span><?php }
                else if (strtotime($new['start_time'])>time()) { ?><span class="badge badge-success">未开始</span><?php }
                else { ?><span class="badge badge-danger"><?php echo $MSG_Runnning;?></span><?php } ?></td>
                <td><?php echo $new['start_time'];?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
        </div>
                <br><div class="card"><div class="card-body">
            <h4>注意！</h4>本主题还不是很稳定，请加QQ群：753870126，有问题及时反馈!<img src='http://hustoj.com/wx.jpg' width='120px'><img src='http://hustoj.com/alipay.png' width='120px'><br> 欢迎关注微信公众号onlinejudge
    </div>
        </div>
        </div>
        </div>
       
    <?php if ($THEME_HOME_STATISTICS == "show") { ?>
<script>
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
<?php } ?>
<?php if ($THEME_AUTO_GET_LATEST_INFO == "yes") { ?>
<script>
$("#info-version").html($.ajax({url:"https://vt-dev-team.github.io/bshark/version",async:false}).responseText);
</script>
<?php } ?>

<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
