<?php
          if($pr_flag){
            $show_title="P$id - ".$row['title']." - $OJ_NAME";
          }else{
            $id=$row['problem_id'];
            $show_title="问题 ".$PID[$pid].": ".$row['title']." - $OJ_NAME";
          }
?>
<?php include("template/$OJ_TEMPLATE/header.php");?>
<style>
.ace_cursor {
  border-left-width: 1px !important;
  color: #000 !important;
}

#languages-menu::-webkit-scrollbar, #testcase-menu::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}

div[class*=ace_br] {
    border-radius: 0 !important;
}
.copy {
    font-size: 12px;
    color: #4d4d4d;
    background-color: white;
    padding: 2px 8px;
    margin: 8px;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.05);
}
</style>
<script src="https://cdnjs.loli.net/ajax/libs/ace/1.4.1/ace.js"></script>
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>clipboard.min.js"></script>
<div class="ui center aligned grid">
    <div class="row">
      <h1 class="ui header">
        <?php
          if($pr_flag){
            echo "$id: ".$row['title'];
            // <%= problem.title %><% if (problem.allowedEdit && !problem.is_public) { %><span class="ui tiny red label">未公开</span><% } %>";
            //echo "<title>$MSG_PROBLEM".$row['problem_id']."--". $row['title']."</title>";
            //echo "<center><h2><strong>$id: ".$row['title']."</strong></h2>";
          }else{
            $id=$row['problem_id'];
            //echo "<title>$MSG_PROBLEM ".$PID[$pid].": ".$row['title']." </title>";
            echo "问题 ".$PID[$pid].": ".$row['title'];
          }
          if($row['defunct']==Y)
          echo "<span class=\"ui tiny red label\">未公开</span>";
        ?>
      </h1>
    </div>
      <div class="row" style="margin-top: -15px">
          <span class="ui label">内存限制：<?php echo $row['memory_limit']; ?> MB</span>
          <span class="ui label">时间限制：<?php echo $row['time_limit']; ?> S</span>
          <!-- <span class="ui label">题目类型：交互</span> -->
          <!-- <span class="ui label">输入文件: <%= problem.file_io_input_name %></span>
          <span class="ui label">输出文件: <%= problem.file_io_output_name %></span> -->
          <!-- echo "<br><span class=green>$MSG_SUBMIT: </span>".$row['submit']."&nbsp;&nbsp;";
          echo "<span class=green>$MSG_SOVLED: </span>".$row['accepted']."<br>"; -->
          <span class="ui label">标准输入输出</span>
      </div>
      <div class="row" style="margin-top: -23px">
          <span class="ui label">题目类型：传统</span>
          <span class="ui label">评测方式：<?php if($row['spj']) echo "Special Judge"; else echo "文本比较" ; ?></span>
          <span class="ui label">上传者：<span id='creator'></span></span>
      </div>
      <div class="row" style="margin-top: -23px">
          <span class="ui label">提交：<?php echo $row['submit']; ?></span>
          <span class="ui label">通过：<?php echo $row['accepted']; ?></span>
      </div>
</div>
<div class="ui grid">
  <div class="row">
    <div class="column">
      <div class="ui buttons">

          <?php
            if($pr_flag){
              echo "<a class=\"small ui primary button\" href=\"submitpage.php?id=$id\">提交</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$id\">提交记录</a>";
              echo "<a class=\"small ui orange button\" href=\"problemstatus.php?id=$id\">统计</a>";
            }else{
              echo "<a href=\"contest.php?cid=$cid\" class=\"ui orange button\">返回比赛</a>";
              echo "<a class=\"small ui primary button\" href=\"submitpage.php?cid=$cid&pid=$pid&langmask=$langmask\">提交</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$PID[$pid]&cid=$cid\">提交记录</a>";
            }
          ?>
          
      </div>
     
      <?php
        if(isset($_SESSION[$OJ_NAME.'_'.'administrator'])){
        require_once("include/set_get_key.php");
      ?>
      
        <div class="ui buttons right floated">
            <a class="small ui button" href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>">编辑题目</a>
            <a class="small ui button" href='javascript:phpfm(<?php echo $row['problem_id'];?>)'>测试数据</a>
        </div>
      <?php }?>
    </div>
  </div>

  <div class="row">
    <div class="column">
      <h4 class="ui top attached block header">题目描述</h4>
      <div class="ui bottom attached segment font-content"><?php echo $row['description']; ?></div>
    </div>
  </div>
  <?php if($row['input']){ ?>
    <div class="row">
      <div class="column">
          <h4 class="ui top attached block header">输入格式</h4>
          <div class="ui bottom attached segment font-content"><?php echo $row['input']; ?></div>
      </div>
    </div>
  <?php }?>
  <?php if($row['output']){ ?>
    <div class="row">
        <div class="column">
          <h4 class="ui top attached block header">输出格式</h4>
          <div class="ui bottom attached segment font-content"><?php echo $row['output']; ?></div>
        </div>
    </div>
  <?php }?>

  <?php
    $sinput=str_replace("<","&lt;",$row['sample_input']);
    $sinput=str_replace(">","&gt;",$sinput);
    $soutput=str_replace("<","&lt;",$row['sample_output']);
    $soutput=str_replace(">","&gt;",$soutput);
  ?>
  <?php if(strlen($sinput)){ ?>
    <div class="row">
        <div class="column">
          <h4 class="ui top attached block header">输入样例
          <span class="copy" id="copyin" data-clipboard-text="<?php echo ($sinput); ?>">复制</span>
          </h4>
          <!-- <span class=copy id=\"copyin\" data-clipboard-text=\"".($sinput)."\">复制</span> -->
          <div class="ui bottom attached segment font-content">
            <!-- <pre><?php echo ($sinput); ?></pre> -->
            <pre style="margin-top: 0; margin-bottom: 0; "><code class="lang-plain"><?php echo ($sinput); ?></code></pre>
          </div>
        </div>
    </div>
  <?php }?>
  <?php if(strlen($sinput)){ ?>
    <div class="row">
        <div class="column">
          <h4 class="ui top attached block header">输出样例
          <span class="copy" id="copyout" data-clipboard-text="<?php echo ($soutput); ?>">复制</span>
          </h4>
          <!-- <span class=copy id=\"copyout\" data-clipboard-text=\"".($soutput)."\">复制</span> -->
          <div class="ui bottom attached segment font-content">
            <!-- <div class="ui existing segment"> -->
              <pre style="margin-top: 0; margin-bottom: 0; "><code class="lang-plain"><?php echo ($soutput); ?></code></pre>
            <!-- </div> -->
          </div>
        </div>
    </div>
  <?php }?>
  <?php if($row['hint']){ ?>
    <div class="row">
        <div class="column">
          <h4 class="ui top attached block header">数据范围与提示</h4>
          <div class="ui bottom attached segment font-content"><?php echo $row['hint']; ?></div>
        </div>
    </div>
  <?php }?>
  <?php
    $color=array("blue","teal","orange","pink","olive","red","violet","yellow","green","purple");
    $tcolor=0;
  ?>
  <?php if($row['source']){
    $cats=explode(" ",$row['source']);
  ?>
    <div class="row">
      <div class="column">
        <h4 class="ui block header top attached" id="show_tag_title_div" style="margin-bottom: 0; margin-left: -1px; margin-right: -1px; ">
        分类标签
        </h4>
        <div class="ui bottom attached segment" id="show_tag_div">

          <?php foreach($cats as $cat){ 
            $label_theme=$color[$tcolor%count($color)];
            $tcolor++;
            ?>
            <a href="<?php echo "problemset.php?search=".htmlentities($cat,ENT_QUOTES,'utf-8') ?>" class="ui medium <?php echo $label_theme; ?> label">
              <?php echo htmlentities($cat,ENT_QUOTES,'utf-8'); ?>
            </a>
          <?php } ?>

        </div>
      </div>
    </div>
  <?php } ?>
  
    
</div>

  <script type="text/javascript">
  var editor = ace.edit("editor");
  var lastSubmitted = '';

  editor.setTheme("ace/theme/tomorrow");
  editor.getSession().setMode("ace/mode/" + $('#languages-menu .item.active').data('mode'));
  editor.getSession().setUseSoftTabs(false);

  editor.container.style.lineHeight = 1.6;
  editor.container.style.fontSize = '14px';
  editor.container.style.fontFamily = "'Roboto Mono', 'Bitstream Vera Sans Mono', 'Menlo', 'Consolas', 'Lucida Console', monospace";
  editor.setShowPrintMargin(false);
  editor.renderer.updateFontSize();

  function submit_code() {
    if (!$('#submit_code input[name=answer]').val().trim() && !editor.getValue().trim()) return false;
    $('#submit_code input[name=language]').val($('#languages-menu .item.active').data('value'));
    lastSubmitted = editor.getValue();
    $('#submit_code input[name=code]').val(editor.getValue());
    return true;
  }

  $('#languages-menu')[0].scrollTop = $('#languages-menu .active')[0].offsetTop - $('#languages-menu')[0].firstElementChild.offsetTop;

  $(function () {
    $('#languages-menu .item').click(function() {
      $(this)
        .addClass('active')
        .closest('.ui.menu')
        .find('.item')
          .not($(this))
          .removeClass('active')
      ;
      editor.getSession().setMode("ace/mode/" + $(this).data('mode'));
    });
  });
  </script>

  <script src="https://cdn.staticfile.org/css-element-queries/0.4.0/ResizeSensor.min.js"></script>

  
<?php include("template/$OJ_TEMPLATE/footer.php");?>

  <script>
  function phpfm(pid){
    //alert(pid);
    $.post("admin/phpfm.php",{'frame':3,'pid':pid,'pass':''},function(data,status){
      if(status=="success"){
        document.location.href="admin/phpfm.php?frame=3&pid="+pid;
      }
    });
  }

  $(document).ready(function(){
    $("#creator").load("problem-ajax.php?pid=<?php echo $id?>");
  });
  </script>   


  <script>
    var clipboardin=new Clipboard(copyin);
    clipboardin.on('success', function(e){
      $("#copyin").text("复制成功!"); 
          setTimeout(function () {$("#copyin").text("复制"); }, 1500);    
      console.log(e);
    });
    clipboardin.on('error', function(e){
      $("#copyin").text("复制失败!"); 
          setTimeout(function () {$("#copyin").text("复制"); }, 1500);
      console.log(e);
    });

    var clipboardout=new Clipboard(copyout);
    clipboardout.on('success', function(e){
      $("#copyout").text("复制成功!"); 
          setTimeout(function () {$("#copyout").text("复制"); }, 1500);    
      console.log(e);
    });
    clipboardout.on('error', function(e){
      $("#copyout").text("复制失败!"); 
          setTimeout(function () {$("#copyout").text("复制"); }, 1500);
      console.log(e);
    });

  </script>
