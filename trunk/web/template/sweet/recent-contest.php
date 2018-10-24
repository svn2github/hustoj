<?php
$cur_path = "template/$OJ_TEMPLATE/"
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title><?php echo $OJ_NAME?></title>  
<!--    --><?php //include("template/$OJ_TEMPLATE/css.php");?><!--	    -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="container">
    <?php include("template/$OJ_TEMPLATE/nav.php");?>	    
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
<div id=main>
	<table lay-filter="demo">
<thead class=toprow>
	<tr>
		<th lay-data="{field:'username',}">OJ</th><th lay-data="{field:'username1',}">Name</th><th class="column-3" lay-data="{field:'username2', width:100}">Start Time</th><th class="column-4" lay-data="{field:'username3', width:100}">Week</th><th class="column-5" lay-data="{field:'username4', width:100}">Access</th>
	</tr>
</thead>
<tbody class="row-hover">
<?php
//echo $json;
$odd=true;
$limit = 0;
 foreach($rows as $row) {
   $odd=!$odd;
?>
  <tr>
		<td><?php echo$row['oj']?></td><td class="column-2"><a id="name_<?php echo$row['id']?>" href="<?php echo$row['link']?>" target="_blank"><?php echo$row['name']?></a></td><td class="column-3"><?php echo$row['start_time']?></td><td class="column-4"><?php echo$row['week']?></td><td class="column-5"><?php echo$row['access']?></td>
  </tr>
<?php
 $limit++;
 } ?>
</tbody>
</table>
</div>
          <script>

              layui.use('table', function(){
                  var table = layui.table;

                  //转换静态表格
                  table.init('demo', {
                      // height: 315 //设置高度
                      // ,
                      limit: <?php echo $limit ?> //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
                      //支持所有基础参数
                  });
                  // var element = layui.element;
                  //…
              });

          </script>
<div align=center>DataSource:http://contests.acmicpc.info/contests.json  Spider Author:<a href="http://contests.acmicpc.info" >doraemonok</a></div>

      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php include("template/$OJ_TEMPLATE/js.php");?>	    
  </body>
</html>
