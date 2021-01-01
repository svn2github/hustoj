<?php $show_title="排名 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>

<div class="padding">
  <a href="ranklist.php?scope=d">Day</a>
  <a href="ranklist.php?scope=w">Week</a>
  <a href="ranklist.php?scope=m">Month</a>
  <a href="ranklist.php?scope=y">Year</a>
  <form action="ranklist.php" class="ui mini form" method="get" role="form" style="margin-bottom: 25px; text-align: right; ">
    <div class="ui action left icon input inline" style="width: 180px; margin-right: 77px; ">
      <i class="search icon"></i><input name="prefix" placeholder="用户名" type="text" value="<?php echo htmlentities(isset($_GET['prefix'])?$_GET['prefix']:"",ENT_QUOTES,"utf-8") ?>">
      <button class="ui mini button" type="submit">查找用户</button>
    </div>
  </form>
	    <table class="ui very basic center aligned table" style="table-layout: fixed; ">
	        <thead>
	        <tr>
	            <th style="width: 60px; ">#</th>
	            <th style="width: 180px; ">用户名</th>
	            <th>昵称</th>
              <th style="width: 100px; ">通过数</th>
              <th style="width: 100px; ">提交数</th>
              <th style="width: 100px; ">比率</th>
	        </tr>
	        </thead>
	        <tbody>
          <?php
          foreach($view_rank as $row){
          echo "<tr>";
          foreach($row as $table_cell){
          echo "<td>";
          echo "\t".$table_cell;
          echo "</td>";
          }
          echo "</tr>";
          }
          ?>
	        </tbody>
	    </table>
    <br>
    <div style="margin-bottom: 30px; ">
  
  <div style="text-align: center; ">
	<div class="ui pagination menu" style="box-shadow: none; ">      
    <?php
    for($i = 0; $i <$view_total ; $i += $page_size) {
    $str= "<a class=\"icon item\" href='./ranklist.php?start=" . strval ( $i ).($scope?"&scope=$scope":"") . "'>";
    $str.= strval ( $i + 1 );
    $str.= "-";
    $str.= strval ( $i + $page_size );
    $str.= "</a>";
    echo $str;
    }
    ?>
	</div>
  </div>
</div>
</div>

<?php include("template/$OJ_TEMPLATE/footer.php");?>
