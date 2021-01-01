<?php $show_title="问题列表 - $OJ_NAME"; ?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<div class="padding">

  <div class="ui grid" style="margin-bottom: 10px; ">
    <div class="row" style="white-space: nowrap; ">
      <div class="seven wide column">
          <form action="" method="get">
            <div class="ui search" style="width: 280px; height: 28px; margin-top: -5.3px; ">
              <div class="ui left icon input" style="width: 100%; ">
                <input class="prompt" style="width: 100%; " type="text" value="" placeholder=" 题目名 …" name="search">
                <i class="search icon"></i>
              </div>
              <div class="results" style="width: 100%; "></div>
            </div>
          </form>

          <!-- <form action="<%= syzoj.utils.makeUrl(['problems', 'search']) %>" method="get">
            <div class="ui search" style="width: 280px; height: 28px; margin-top: -5.3px; ">
              <div class="ui left icon input" style="width: 100%; ">
                <input class="prompt" style="width: 100%; " type="text" value="<%= req.query.keyword %>" placeholder="ID / 题目名 …" name="keyword">
                <i class="search icon"></i>
              </div>
              <div class="results" style="width: 100%; "></div>
            </div>
          </form> -->
      </div>


      <div class="nine wide right aligned column">
     
        <div class="ui toggle checkbox" id="show_tag">
          <style id="show_tag_style"></style>
          <script>
          if (localStorage.getItem('show_tag') === '1') {
            document.write('<input type="checkbox" checked>');
            document.getElementById('show_tag_style').innerHTML = '.show_tag_controled { white-space: nowrap; overflow: hidden; }';
          } else {
            document.write('<input type="checkbox">');
            document.getElementById('show_tag_style').innerHTML = '.show_tag_controled { width: 0; white-space: nowrap; overflow: hidden; }';
          }
          </script>

          <script>
          $(function () {
            $('#show_tag').checkbox('setting', 'onChange', function () {
              let checked = $('#show_tag').checkbox('is checked');
              localStorage.setItem('show_tag', checked ? '1' : '0');
              if (checked) {
                document.getElementById('show_tag_style').innerHTML = '.show_tag_controled { white-space: nowrap; overflow: hidden; }';
              } else {
                document.getElementById('show_tag_style').innerHTML = '.show_tag_controled { width: 0; white-space: nowrap; overflow: hidden; }';
              }
            });
          });
          </script>
          <label>显示分类标签</label>
          
        </div>
        <div style="margin-left: 10px; display: inline-block; ">
              <!-- <a style="margin-left: 10px; " href="<%= syzoj.utils.makeUrl(['problems', 'tag', tags[0].id, 'edit']) %>" class="ui labeled icon mini blue button"><i class="write icon"></i> 编辑标签</a> -->
            <a style="margin-left: 10px; " href="category.php" class="ui labeled icon mini green button"><i class="plus icon"></i> 查看全部标签</a>
          <!-- <div style="margin-left: 10px; " class="ui mini buttons">
            <div class="ui labeled icon mini dropdown button" id="add_problem_dropdown"><i class="plus icon"></i> 添加题目
            <div class="menu">
              <a class="item" href="<%= syzoj.utils.makeUrl(['problem', 0, 'edit']) %>"><i class="file icon"></i> 新建题目</a>
              <a class="item" href="<%= syzoj.utils.makeUrl(['problem', 0, 'import']) %>"><i class="cloud download icon"></i> 导入题目</a>
            </div>
            </div>
          </div> -->
        </div>

      </div>
    </div>
  </div>


<div style="margin-bottom: 30px; ">
    
    <?php
      if(!isset($page)) $page=1;
      $page=intval($page);
      $section=8;
      $start=$page>$section?$page-$section:1;
      $end=$page+$section>$view_total_page?$view_total_page:$page+$section;
    ?>
<div style="text-align: center; ">
  <div class="ui pagination menu" style="box-shadow: none; ">
    <a class="<?php if($page==1) echo "disabled "; ?>icon item" href="<?php if($page<>1) echo "problemset.php?page=".($page-1); ?>" id="page_prev">  
      <i class="left chevron icon"></i>
    </a>
    <?php
      for ($i=$start;$i<=$end;$i++){
        echo "<a class=\"".($page==$i?"active ":"")."item\" href=\"problemset.php?page=".$i."\">".$i."</a>";
      }
    ?>
    <a class="<?php if($page==$view_total_page) echo "disabled "; ?> icon item" href="<?php if($page<>$view_total_page) echo "problemset.php?page=".($page+1); ?>" id="page_next">
    <i class="right chevron icon"></i>
    </a>  
  </div>
</div>

</div>


  <table class="ui very basic center aligned table">
    <thead>
      <tr>

        <?php if (isset($_SESSION[$OJ_NAME.'_'.'user_id'])){?>
          <th class="one wide">提交状态</th>
        <?php } ?>
        <th class="one wide">编号</th>
        <th class="left aligned">题目名称</th>
        <th class="one wide">通过</th>
        <th class="one wide">提交</th>
        <th class="one wide">通过率</th>
      </tr>
    </thead>
    <tbody>
      
      
      
      <?php
          // $view_problemset=Array();
          // $i=0;
          // foreach ($result as $row){
            
            
          //   $view_problemset[$i]=Array();
          //   if (isset($sub_arr[$row['problem_id']])){
          //     if (isset($acc_arr[$row['problem_id']])) 
          //     $view_problemset[$i][0]="<div class='label label-success'>Y</div>";
          //   	else 
          //     $view_problemset[$i][0]= "<div class='label label-danger'>N</div>";
          //   }else{
          //     $view_problemset[$i][0]= "<div class=none> </div>";
          //   }
          //   $category=array();
          //   $cate=explode(" ",$row['source']);
          //   foreach($cate as $cat){
          //   	array_push($category,trim($cat));	
          //   }
          //   $view_problemset[$i][1]="<div class='center'>".$row['problem_id']."</div>";;
          //   $view_problemset[$i][2]="<div class='left'><a href='problem.php?id=".$row['problem_id']."'>".$row['title']."</a></div>";;
          //   $view_problemset[$i][3]="<div class='center'>";
          //   foreach($category as $cat){
          //     if(trim($cat)=="")continue;
          //   	$hash_num=hexdec(substr(md5($cat),0,15));
          //   	$label_theme=$color_theme[$hash_num%count($color_theme)];
          //   	$view_problemset[$i][3].="<a class='label label-$label_theme' style='display: inline-block;' href='problemset.php?search=".htmlentities($cat,ENT_QUOTES,'UTF-8')."'>".mb_substr($cat,0,4,'utf8')."</a>&nbsp;";
          //   }
          //   $view_problemset[$i][3].="</div >";
          //   $view_problemset[$i][4]="<div class='center'><a href='status.php?problem_id=".$row['problem_id']."&jresult=4'>".$row['accepted']."</a></div>";
          //   $view_problemset[$i][5]="<div class='center'><a href='status.php?problem_id=".$row['problem_id']."'>".$row['submit']."</a></div>";
            
            
          //   $i++;
          // }
            

          // foreach($view_problemset as $row){

          //       echo "<td  class='hidden-xs'>";
          //       else 
          //       echo "<td>";
          //       echo "\t".$table_cell;
          //       echo "</td>";
          //     $i++;
          //   }
          //   echo "</tr>";
          // }
          ?>

        <?php
          $color=array("blue","teal","orange","pink","olive","red","yellow","green","purple");
          $tcolor=0;
          $i=0;
          foreach ($result as $row){
		echo "<tr>";
            if (isset($_SESSION[$OJ_NAME.'_'.'user_id'])){

              if (isset($sub_arr[$row['problem_id']])){
                if (isset($acc_arr[$row['problem_id']])) 
                  echo "<td><span class=\"status accepted\"><i class=\"checkmark icon\"></i></span></td>";
                else 
                  echo "<td><span class=\"status wrong_answer\"><i class=\"remove icon\"></i></span></td>";
              }else{
                echo "<td><span class=\"status\"><i class=\"icon\"></i></span></td>";
              }
            }

             echo  "<td><b>".$row['problem_id']."</b></td>";
             echo "<td class=\"left aligned\">";
             echo "<a style=\"vertical-align: middle; \" href=\"problem.php?id=".$row['problem_id']."\">";
             echo $row['title'];
             echo "</a>";
             if($row['defunct']=='Y')
              echo "<span class=\"ui tiny red label\">未公开</span>";

              echo "<div class=\"show_tag_controled\" style=\"float: right; \">";
              echo "<span class=\"ui header\">";
              $category=array();
              $cate=explode(" ",$row['source']);
              foreach($cate as $cat){
                array_push($category,trim($cat));	
              }
              $tcolor=0;
              foreach($category as $cat){
                if(trim($cat)=="") continue;
                $hash_num=hexdec(substr(md5($cat),0,15));
                $label_theme=$color[$tcolor%count($color)];
                $tcolor++;
                echo "<a href=\"problemset.php?search=".htmlentities($cat,ENT_QUOTES,'UTF-8')."\" class=\"ui tiny ".$label_theme." label\">";
                         echo htmlentities($cat,ENT_QUOTES,'UTF-8');
                echo "</a>";
              }

              echo "</span></div>";
            echo "</td>";
            echo "<td><a href=\"status.php?problem_id=".$row['problem_id']."&jresult=4\">".$row['accepted']."</a></td>";
            echo "<td><a href='status.php?problem_id=".$row['problem_id']."'>".$row['submit']."</a></td>";
            if ($row['submit'] == 0)
              echo "<td>0.000%</td>";
            else{
              $tt = sprintf ( "%.03lf%%", 100 * $row['accepted'] / $row['submit'] );
              echo "<td>".$tt."</td>";
            }
            echo  "</tr>";
          }
        ?>



    </tbody>
  </table><br>
  <div style="margin-bottom: 30px; ">
    
    <?php
      if(!isset($page)) $page=1;
      $page=intval($page);
      $section=8;
      $start=$page>$section?$page-$section:1;
      $end=$page+$section>$view_total_page?$view_total_page:$page+$section;
    ?>
<div style="text-align: center; ">
  <div class="ui pagination menu" style="box-shadow: none; ">
    <a class="<?php if($page==1) echo "disabled "; ?>icon item" href="<?php if($page<>1) echo "problemset.php?page=".($page-1); ?>" id="page_prev">  
      <i class="left chevron icon"></i>
    </a>
    <?php
      for ($i=$start;$i<=$end;$i++){
        echo "<a class=\"".($page==$i?"active ":"")."item\" href=\"problemset.php?page=".$i."\">".$i."</a>";
      }
    ?>
    <a class="<?php if($page==$view_total_page) echo "disabled "; ?> icon item" href="<?php if($page<>$view_total_page) echo "problemset.php?page=".($page+1); ?>" id="page_next">
    <i class="right chevron icon"></i>
    </a>  
  </div>
</div>
<script type="text/javascript" src="include/jquery.tablesorter.js"></script>

</div>
<?php include("template/$OJ_TEMPLATE/footer.php");?>
   
