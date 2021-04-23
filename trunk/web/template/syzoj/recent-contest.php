<?php $show_title="近期比赛 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>

    <table class="ui very basic center aligned table">
      <thead>
        <tr>
        <th>OJ</th>
        <th>比赛名称</th>
        <th>开始时间</th>
        <th>星期</th>
        <th>Access</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $odd=true;
        foreach($rows as $row) {
        ?>
          <tr>
            <td><?php echo$row['oj']?></td>
            <td><a href="<?php echo$row['link']?>" target="_blank"><?php echo$row['name']?></a></td>
            <td><?php echo$row['start_time']?></td>
            <td><?php echo$row['week']?></td>
            <td><?php echo$row['access']?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <div>数据来源：<a href="http://contests.acmicpc.info/contests.json" target="_blank">http://contests.acmicpc.info/contests.json</a>&nbsp;&nbsp;&nbsp;&nbsp;作者：<a href="http://contests.acmicpc.info"  target="_blank" >doraemonok</a></div>

<?php include("template/$OJ_TEMPLATE/footer.php");?>