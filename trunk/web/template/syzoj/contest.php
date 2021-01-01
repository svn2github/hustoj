<?php $show_title="Contest".$view_cid." - ".$view_title." - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<style>
.ui.label.pointing.below.left::before {
    left: 12%;
}

.ui.label.pointing.below.right::before {
    left: 88%;
}

.ui.label.pointing.below.left {
    margin-bottom: 0;
}

.ui.label.pointing.below.right {
    margin-bottom: 0;
    float: right;
}

#back_to_contest {
    display: none;
}
</style>

<div class="padding">
    <h1>Contest<?php echo $view_cid?> - <?php echo $view_title ?></h1>
    <div class="ui pointing below left label"><?php echo $view_start_time?></div>
    <div class="ui pointing below right label"><?php echo $view_end_time?></div>

    <div id="timer-progress" class="ui tiny indicating progress success" data-percent="50">
        <div class="bar" style="width: 0%; transition-duration: 300ms;"></div>
    </div>

    <div class="ui grid">
        <div class="row">
            <div class="column">
                <div class="ui buttons">
                    <a class="ui small blue button" href="contestrank.php?cid=<?php echo $view_cid?>">排行榜</a>
                    <a class="ui small positive button" href="status.php?cid=<?php echo $view_cid?>">提交记录</a>
                    <!-- <a class="ui small pink button" href="conteststatistics.php?cid=<?php echo $view_cid?>">比赛统计</a> -->
                </div>
                <div class="ui buttons right floated">

                    <?php
          if ($now>$end_time)
          echo "<span class=\"ui small button grey\">已结束</span>";
          else if ($now<$start_time)
          echo "<span class=\"ui small button red\">未开始</span>";
          else
          echo "<span class=\"ui small button green\">进行中</span>";
          ?>
                    <?php
          if ($view_private=='0')
          echo "<span class=\"ui small button blue\">公开</span>";
          else
          echo "<span class=\"ui small button pink\">私有</span>";
          ?>
                    <span class="ui small button">当前时间：<span id=nowdate><?php echo date("Y-m-d H:i:s")?></span></span>
                </div>
            </div>
        </div>
        <?php if($view_description){ ?>
        <div class="row">
            <div class="column">
                <h4 class="ui top attached block header">信息与公告</h4>
                <div class="ui bottom attached segment font-content">
                    <?php echo $view_description?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="column">
                <table class="ui selectable celled table">
                    <thead>
                        <tr>
                            <?php if(isset($_SESSION[$OJ_NAME.'_'.'user_id'])) echo "<th class=\"one wide\" style=\"text-align: center\">状态</th>" ?>
                            <th class="two wide" style="text-align: center">题目编号</th>
                            <th>题目</th>
                            <th>分类</th>
                            <th class="one wide center aligned">正确</th>
                            <th class="one wide center aligned">提交</th>
                        </tr>
                    </thead>
                    <tbody>
                    <pre><code>
                        <?php
                        foreach($view_problemset as $row){
                          echo "<tr>";
                          foreach($row as $table_cell){
                            echo "<td>".$table_cell."</td>";
                          }
                          echo "</tr>";
                        }
                        ?>
                        </pre></code>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('#timer-progress').progress({
        value: Date.now() / 1000 - <?php echo strtotime($view_start_time)?>,
        total: <?php echo (strtotime($view_end_time)- strtotime($view_start_time))?>
    });
});

$(function() {
    setInterval(function() {
        $('#timer-progress').progress({
            value: Date.now() / 1000 - <?php echo strtotime($view_start_time)?>,
            total: <?php echo (strtotime($view_end_time)- strtotime($view_start_time))?>
        });
    }, 5000);
});
</script>
<script src="include/sortTable.js"></script>
<script>
var diff = new Date("<?php echo date("Y/m/d H:i:s")?>").getTime() - new Date().getTime();
//alert(diff);
function clock() {
    var x, h, m, s, n, xingqi, y, mon, d;
    var x = new Date(new Date().getTime() + diff);
    y = x.getYear() + 1900;
    if (y > 3000) y -= 1900;
    mon = x.getMonth() + 1;
    d = x.getDate();
    xingqi = x.getDay();
    h = x.getHours();
    m = x.getMinutes();
    s = x.getSeconds();
    n = y + "-" + mon + "-" + d + " " + (h >= 10 ? h : "0" + h) + ":" + (m >= 10 ? m : "0" + m) + ":" + (s >= 10 ? s :
        "0" + s);
    //alert(n);
    document.getElementById('nowdate').innerHTML = n;
    setTimeout("clock()", 1000);
}
clock();
</script>

<?php include("template/$OJ_TEMPLATE/footer.php");?>