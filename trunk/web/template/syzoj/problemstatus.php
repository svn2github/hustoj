<?php $show_title="题目统计信息 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<style>
#avatar_container:before {
    content: "";
    display: block;
    padding-top: 100%;
}
</style>


<div class="padding">
<div class="ui grid">
    <div class="row">
        <div class="five wide column">
            <div class="ui card" style="width: 100%; " id="user_card">
                <div class="">
                <div class="column">
                      <h4 class="ui top attached block header">统计</h4>
                      <div class="ui bottom attached segment">
                        <div id="pie_chart_legend"></div>
                        <div style="width: 260px; height: 260px; margin-left: 15.5px; "><canvas style="width: 260px; height: 260px; " id="pie_chart"></canvas></div>
                      </div>
                  </div>
                </div>

            </div>

        </div>
        <div class="eleven wide column">
            <div class="ui grid">
                <div class="row">
                    <div class="column">
                        <h4 class="ui top attached block header">排序</h4>
                        <div class="ui bottom attached segment">
                            <table class="ui very basic table">
                              <thead>
                                <tr>
                                  <th>名次</th>
                                  <th>RunID</th>
                                  <th>用户名</th>
                                  <th>内存</th>
                                  <th>时间</th>
                                  <th>语言</th>
                                  <th>代码长度</th>
                                  <th>提交时间</th>
                                </tr>
                              </thead>
                            <tbody>
                            <?php
                            foreach($view_solution as $row){
                            echo "<tr>";
                            foreach($row as $table_cell){
                            echo "<td>";
                            echo "\t".$table_cell;
                            echo "</td>";
                            }
                            echo "</tr>";
                            }
                            ?>
                            <!-- <tr>
                            <td colspan="8">
                              <?php
                              echo "<a href='problemstatus.php?id=$id'>[首页]</a>";
                              echo "<a href='status.php?problem_id=$id'>[评测列表]</a>";
                              if ($page>$pagemin){
                              $page--;
                              echo "<a href='problemstatus.php?id=$id&page=$page'>[上一页]</a>";
                              $page++;
                              }
                              if ($page<$pagemax){
                              $page++;
                              echo "<a href='problemstatus.php?id=$id&page=$page'>[下一页]</a>";
                              $page--;
                              }
                              ?>
                              
                            </td>
                            </tr> -->
                            </table>
                            <div style="margin-bottom: 10px; ">
  
                                <div style="text-align: center; ">
                                <div class="ui pagination menu" style="box-shadow: none; ">
                                  <?php
                                    // <a class="icon item" href="status.php?" id="page_prev">  
                                    // 首页
                                    // </a>
                                    echo "<a class=\"item\" href='problemstatus.php?id=$id'>首页</a>";
                                    if ($page>$pagemin){
                                      $page--;
                                      echo "<a class=\"item\" href='problemstatus.php?id=$id&page=$page'>上一页</a>";
                                      $page++;
                                    }
                                    if ($page<$pagemax){
                                      $page++;
                                      echo "<a class=\"item\" href='problemstatus.php?id=$id&page=$page'>下一页</a>";
                                      $page--;
                                      }
                                    // <a class="item" href="status.php?&amp;top=65577">上一页</a>      
                                    // <a class="icon item" href="status.php?&amp;top=65538&amp;prevtop=65557" id="page_next">
                                    //   下一页
                                    // </a>
                                  ?>
                                </div>
                                </div>
                              </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>
$(function () {
  $('#user_card .image').dimmer({
    on: 'hover'
  });


  var pie = new Chart(document.getElementById('pie_chart').getContext('2d'), {
    aspectRatio: 1,
    type: 'pie',
    data: {
      datasets: [
        {
          data: [
            <?php foreach($view_problem_number as $row){
              echo $row.",";
            }
            ?>
          ],
          backgroundColor: [
            "#32CD32",
            "#FA8072",
            "#DC143C",
            "#FF9912",
            "#8A2BE2",
            "#4169E1",
            "#DB7093",
            "#082E54",
            "#FFFF00",
          ]
        }
      ],
      labels: [
        <?php foreach($view_problem_title as $row){
              echo "\"".$row."\",";
            }
            ?>
      ]
    },
    options: {
      responsive: true,
      legend: {
        display: false
      },
      legendCallback: function (chart) {
  			var text = [];
        text.push('<ul style="list-style: none; padding-left: 20px; margin-top: 0; " class="' + chart.id + '-legend">');
            text.push('<li style="font-size: 12px; width: 50%; display: inline-block; color: #666; "><span style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; margin-right: 5px; background-color: #32CD32 ; "></span>');
                text.push('<?php echo "总提交: ".$view_problem[0][1]; ?>');
            text.push('</li>');
            text.push('<li style="font-size: 12px; width: 50%; display: inline-block; color: #666; "><span style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; margin-right: 5px; background-color: #32CD32 ; "></span>');
                text.push('<?php echo "用户(提交): ".$view_problem[1][1]; ?>');
            text.push('</li>');
            text.push('<li style="font-size: 12px; width: 50%; display: inline-block; color: #666; "><span style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; margin-right: 5px; background-color: #32CD32 ; "></span>');
                text.push('<?php echo "用户(解决): ".$view_problem[2][1]; ?>');
            text.push('</li>');
        text.push('</ul>');

  			text.push('<ul style="list-style: none; padding-left: 20px; margin-top: 0; " class="' + chart.id + '-legend">');

  			var data = chart.data;
  			var datasets = data.datasets;
  			var labels = data.labels;
        
  			if (datasets.length) {
  				for (var i = 0; i < datasets[0].data.length; ++i) {
  					text.push('<li style="font-size: 12px; width: 50%; display: inline-block; color: #666; "><span style="width: 10px; height: 10px; display: inline-block; border-radius: 50%; margin-right: 5px; background-color: ' + datasets[0].backgroundColor[i] + '; "></span>');
  					if (labels[i]) {
  						text.push(labels[i]);
              text.push(' : ' + datasets[0].data[i]);
  					}
  					text.push('</li>');
  				}
  			}

  			text.push('</ul>');
  			return text.join('');
  		}
    },
  });

  document.getElementById('pie_chart_legend').innerHTML = pie.generateLegend();
});
</script>

<?php include("template/$OJ_TEMPLATE/footer.php");?>

