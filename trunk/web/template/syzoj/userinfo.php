<?php $show_title="用户信息 - $OJ_NAME"; ?>
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
                <div class="blurring dimmable image" id="avatar_container" style="height:325px">
                    <?php $default = ""; $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=500"; ?>
                    <img style="margin-top: -100%; " src="<?php echo $grav_url; ?>">
                </div>
                <div class="content">
                    <div class="header"><?php echo $nick?></div>
                    <div class="meta">
                        <a class="group"><?php echo $school?></a>
                    </div>
                </div>
                <div class="extra content">
                    <a><i class="check icon"></i>通过 <?php echo $AC ?> 题</a>
                    <a style="float: right; "><i class="star icon"></i>排名 <?php echo $Rank ?></a>
                </div>
            </div>

        </div>
        <div class="eleven wide column">
            <div class="ui grid">
                <div class="row">
                    <div class="sixteen wide column">
                        <div class="ui grid">
                            <div class="eight wide column">
                                <div class="ui grid">
                                    <div class="row">
                                        <div class="column">
                                           <h4 class="ui top attached block header">用户名</h4>
                                           <div class="ui bottom attached segment"><?php echo $user?></div>
                                        </div>
                                    </div>
                                      <div class="row">
                                          <div class="column">
                                              <h4 class="ui top attached block header">Email</h4>
                                              <div class="ui bottom attached segment" class="font-content"><?php echo $email?></div>
                                          </div>
                                      </div>
                                    <div class="row">
                                        <div class="column">
                                            <h4 class="ui top attached block header">个性签名</h4>
                                            
                                            <div class="ui bottom attached segment" class="font-content"><?php echo $school?></div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="column">
                                            <h4 class="ui top attached block header">注册于</h4>
                                            <div class="ui bottom attached segment" class="font-content">
                                                <%= syzoj.utils.formatDate(show_user.register_time) %>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="column">
                                            <h4 class="ui top attached block header">通过的题目</h4>
                                            <div class="ui bottom attached segment">
                                                <script language='javascript'>
                                                  function p(id,c){
                                                    document.write("<a href=problem.php?id="+id+">"+id+" </a>");
                                                  }
                                                  <?php $sql="SELECT `problem_id`,count(1) from solution where `user_id`=? and result=4 group by `problem_id` ORDER BY `problem_id` ASC";
                                                  if ($result=pdo_query($sql,$user)){ 
                                                      foreach($result as $row)
                                                      echo "p($row[0],$row[1]);";
                                                  }
                                                  ?>
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="eight wide column">
                                <div class="ui grid">
                                  <div class="row">
                                      <div class="column">
                                          <h4 class="ui top attached block header">统计</h4>
                                          <div class="ui bottom attached segment">
                                            <div id="pie_chart_legend"></div>
                                            <div style="width: 260px; height: 260px; margin-left: 33.5px; "><canvas style="width: 260px; height: 260px; " id="pie_chart"></canvas></div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- <div class="row">
                    <div class="column">
                        <h4 class="ui top attached block header">帖子</h4>
                        <div class="ui bottom attached <% if (!show_user.articles.length) { %>center aligned <% } %>segment">
													  <% if (!show_user.articles.length) { %>该用户从未发表帖子<% } else { %>
                            <table class="ui very basic table">
                                <thead>
                                    <tr>
                                        <th>标题</th>
                                        <th>时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <% for (let article of show_user.articles) { %>
                                    <tr>
																			  <td><a href="<%= syzoj.utils.makeUrl(['article', article.id]) %>"><%= article.title %></a></td>
                                        <td><%= syzoj.utils.formatDate(article.public_time) %></td>
                                    </tr>
                                    <% } %>
                                </tbody>
                            </table>
													  <% } %>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="row">
                    <div class="column">
                        <h4 class="ui top attached block header">比赛</h4>
                        <div class="ui bottom attached segment">
                            <table class="ui very basic table">
                                <thead>
                                    <tr>
                                        <th>比赛</th>
                                        <th>名次</th>
                                        <th>积分</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <% for (const history of ratingHistories) { %>
                                    <tr>
                                        <td><%= history.contestName %></td>
                                        <td><%= history.rank != null ? history.rank + " / " + history.participants : '' %></td>
                                        <td><%= history.value %> 
                                            <% if(history.delta != null) { %> 
                                                <span class="<%= history.delta >= 0 ? 'rating_up' : 'rating_down' %>">
                                                (<%= (history.delta < 0 ? '' : '+') + history.delta %>)
                                            <% } %>
                                        </td>
                                    </tr>
                                    <% } %>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> -->
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
            <?php
              foreach($view_userstat as $row){
              echo $row[1].",\n";
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
        <?php
          foreach($view_userstat as $row){
          echo "\"".$jresult[$row[0]]."\",\n";
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
