<?php
$sql='SELECT * FROM `problem`';
$result=pdo_query($sql);
$problem_count=count($result);
$sql='SELECT * FROM `users`';
$result=pdo_query($sql);
$user_count=count($result);
$sql='SELECT * FROM `solution`';
$result=pdo_query($sql);
$submit_count=count($result);
$sql='SELECT * FROM `users` WHERE `user_id`=?';
$result=pdo_query($sql,$_SESSION[$OJ_NAME.'_'.'user_id']);
$ac_count=$result[0]['solved'];
$sql='SELECT * FROM `news` WHERE `importance`<0 AND `defunct`!="Y"';
$result=pdo_query($sql);
$res=$result;
$scope='y';
 $where="where defunct='N' ";
 $s=date('Y').'-'.date('m').'-'.date('d');
 $page_size=50;
 $rank=0;
 $sql="SELECT users.`user_id`,`email`,`nick`,`school`,s.`solved`,t.`submit` FROM `users`
                                        right join
                                        (select count(distinct problem_id) solved ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') and result=4 group by user_id order by solved desc limit " . strval ( $rank ) . ",$page_size) s on users.user_id=s.user_id
                                        left join
                                        (select count( problem_id) submit ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') group by user_id order by submit desc limit " . strval ( $rank ) . ",".($page_size*2).") t on users.user_id=t.user_id
                                ORDER BY s.`solved` DESC,t.submit,reg_time  LIMIT  0,50
                         ";
$result = pdo_query($sql) ;
if($result) $rows_cnt=count($result);
else $rows_cnt=0;
$pttt=$result; $scope='w';
 $where="where defunct='N' ";
$monday=mktime(0, 0, 0, date("m"),date("d")-(date("w")+7)%8+1, date("Y"))                                                            ;
                                        //$monday->subDays(date('w'));
                                        $s=strftime("%Y-%m-%d",$monday);
 $page_size=50;
 $rank=0;
 $sql="SELECT users.`user_id`,`email`,`nick`,`school`,s.`solved`,t.`submit` FROM `users`
                                        right join
                                        (select count(distinct problem_id) solved ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') and result=4 group by user_id order by solved desc limit " . strval ( $rank ) . ",$page_size) s on users.user_id=s.user_id
                                        left join
                                        (select count( problem_id) submit ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') group by user_id order by submit desc limit " . strval ( $rank ) . ",".($page_size*2).") t on users.user_id=t.user_id
                                ORDER BY s.`solved` DESC,t.submit,reg_time  LIMIT  0,50
                         ";
$result = pdo_query($sql) ;
if($result) $rows_cnt=count($result);
else $rows_cnt=0;
$ptttt=$result;$scope='m';
 $where="where defunct='N' ";
$s=date('Y').'-'.date('m').'-01';
 $page_size=50;
 $rank=0;
 $sql="SELECT users.`user_id`,`email`,`nick`,`school`,s.`solved`,t.`submit` FROM `users`
                                        right join
                                        (select count(distinct problem_id) solved ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') and result=4 group by user_id order by solved desc limit " . strval ( $rank ) . ",$page_size) s on users.user_id=s.user_id
                                        left join
                                        (select count( problem_id) submit ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') group by user_id order by submit desc limit " . strval ( $rank ) . ",".($page_size*2).") t on users.user_id=t.user_id
                                ORDER BY s.`solved` DESC,t.submit,reg_time  LIMIT  0,50
                         ";
$result = pdo_query($sql) ;
if($result) $rows_cnt=count($result);
else $rows_cnt=0;
$pttttt=$result;$scope='y';
 $where="where defunct='N' ";
$s=date('Y').'-01-01';
 $page_size=50;
 $rank=0;
 $sql="SELECT users.`user_id`,`nick`,`email`,`school`,s.`solved`,t.`submit` FROM `users`
                                        right join
                                        (select count(distinct problem_id) solved ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') and result=4 group by user_id order by solved desc limit " . strval ( $rank ) . ",$page_size) s on users.user_id=s.user_id
                                        left join
                                        (select count( problem_id) submit ,user_id from solution where in_date>str_to_date('$s','%Y-%m-%d') group by user_id order by submit desc limit " . strval ( $rank ) . ",".($page_size*2).") t on users.user_id=t.user_id
                                ORDER BY s.`solved` DESC,t.submit,reg_time  LIMIT  0,50
                         ";
$result = pdo_query($sql) ;
if($result) $rows_cnt=count($result);
else $rows_cnt=0;
$ptttttt=$result;
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

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>首页 - MasterOJ</title>
        <?php require("./template/bshark/header-files.php");?>
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
?>                <h4>公告</h4>
<table class="table table-hover">
    <thead>
      <tr>
        <th>公告标题</th>
        <th>上传时间</th>
        <th>作者</th>
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
                    </div>
                </div><br>
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
<canvas id="myChart"></canvas></div></div>
</div></div><br><div class="card"><div class="card-body">
    <h4>关于<?php echo $OJ_NAME;?></h4>
    <p>This ACM/ICPC OnlineJudge is a GPL product from hustoj<br>hustoj -- 流行的开源OJ系统，含*.deb安装包和Win集成版。<br>本OJ基于Hustoj，采用BShark主题，BShark主题由<a href="http://masteroj.hustoj.com/userinfo.php?user=yemaster">yemaster</a>开发</p>
    </div></div>
    </div>
    
            <div class="col-md-4"><div class="card"><div class="card-body">
    <h4>搜索题目</h4>
							<form action='problemset.php' class="form-search form-inline">
							        <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="iconfont icon-search"></i></span>
        </div>
								<input type="text" name=search class="form-control search-query" placeholder="关键字" style="display:inline;width:auto">
								</div>
							</form>
    </div>
        </div>
                <br><div class="card"><div class="card-body">
    <h4>近期比赛</h4>
    <?php 
    $sql = "SELECT * FROM `contest` WHERE `defunct`!='Y' ORDER BY UNIX_TIMESTAMP(`start_time`) DESC LIMIT 5";
    $ress = pdo_query($sql);
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="auto">标题</th>
                <th width="auto">状态</th>
                <th width="auto">开始时间</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ress as $new) { ?>
            <tr>
                <td><a href="contest.php?cid=<?php echo $new['contest_id'];?>"><?php echo $new['title'];?></a></td> 
                <td><?php if (strtotime($new['end_time'])<time()) { ?><span class="badge badge-secondary">已结束</span><?php }
                else if (strtotime($new['start_time'])>time()) { ?><span class="badge badge-success">未开始</span><?php }
                else { ?><span class="badge badge-danger">运行中</span><?php } ?></td>
                <td><?php echo $new['start_time'];?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
        </div>
                <br><div class="card"><div class="card-body">
    <h4>友情链接</h4>
    <ul>
        
    </ul>
    </div>
        </div>
        </div>
        </div>
       
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

<?php require("./template/bshark/footer.php");?>
<?php require("./template/bshark/footer-files.php");?>
    </body>
</html>
