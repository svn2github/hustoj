<?php
          if($pr_flag){
            $show_title="P$id - ".$row['title']." - $OJ_NAME";
          }else{
            $id=$row['problem_id'];
            $show_title="$MSG_PROBLEM ".$PID[$pid].": ".$row['title']." - $OJ_NAME";
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
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>clipboard.min.js"></script>
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/bs3/"?>marked.min.js"></script>
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
            echo "$MSG_PROBLEM ".$PID[$pid].": ".$row['title'];
          }
          if($row['defunct']=="Y")
          echo "<span class=\"p-label ui tiny red label\">$MSG_RESERVED</span>";
        ?>
      </h1>
    </div>
      <div class="row" style="margin-top: -15px">
          <span class="ui label"><?php echo $MSG_Memory_Limit ?>：<?php echo $row['memory_limit']; ?> MB</span>
          <span class="ui label"><?php echo $MSG_Time_Limit ?>：<?php echo $row['time_limit']; ?> S</span>
         <!-- <span class="ui label">标准输入输出</span> -->
      </div>
      <div class="row" style="margin-top: -23px">
        <!--   <span class="ui label">题目类型：传统</span> -->
          <span class="ui label"><?php echo $MSG_JUDGE_STYLE ?>：<?php if($row['spj']) echo "$MSG_SPJ"; else echo "$MSG_TEXT_COMPARE" ; ?></span>
          <span class="ui label"><?php echo $MSG_Creator ?>：<span id='creator'></span></span>
      </div>
      <div class="row" style="margin-top: -23px">
          <span class="ui label"><?php echo $MSG_SUBMIT ?>：<?php echo $row['submit']; ?></span>
          <span class="ui label"><?php echo $MSG_SOVLED ?>：<?php echo $row['accepted']; ?></span>
      </div>
</div>  
<div class="ui grid">
  <div class="row" id="submit-buttons"> 
    <div class="column">
      <div class="ui buttons">

          <?php
            if($pr_flag){
              echo "<a id='submit'  class=\"small ui primary button\" href=\"submitpage.php?id=$id\">$MSG_SUBMIT</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$id\">$MSG_SUBMIT_RECORD</a>";
              echo "<a class=\"small ui orange button\" href=\"problemstatus.php?id=$id\">$MSG_STATISTICS</a>";
	      if($OJ_BBS)echo "<a class=\"small ui red button\" href=\"discuss.php?pid=$id\">$MSG_BBS</a>";
            }else{
              echo "<a href=\"contest.php?cid=$cid\" class=\"ui orange button\">$MSG_RETURN_CONTEST</a>";
              echo "<a id='submit'  class=\"small ui primary button\" href=\"submitpage.php?cid=$cid&pid=$pid&langmask=$langmask\">$MSG_SUBMIT</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$PID[$pid]&cid=$cid\">$MSG_SUBMIT_RECORD</a>";
            }
	      echo "<a class='small ui primary button' href='#' onclick='transform()' role='button'>$MSG_SHOW_OFF</a>";
          ?>
          
      </div>
     
      <?php
        if ( isset($_SESSION[$OJ_NAME.'_'.'administrator']) || isset($_SESSION[$OJ_NAME.'_'."p".$row['problem_id']])  ) {  //only  the original editor can edit this  problem
        
        require_once("include/set_get_key.php");
      ?>
      
        <div class="ui buttons right floated">
            <a class="small ui button" href="admin/problem_edit.php?id=<?php echo $id?>&getkey=<?php echo $_SESSION[$OJ_NAME.'_'.'getkey']?>"><?php echo $MSG_EDIT.$MSG_PROBLEM?></a>
            <a class="small ui button" href='javascript:phpfm(<?php echo $row['problem_id'];?>)'><?php echo $MSG_TEST_DATA?></a>
        </div>
      <?php }?>
    </div>
  </div>

  <div class="row">
    <div class="column">
      <h4 class="ui top attached block header"><?php echo $MSG_Description?></h4>
      <div class="ui bottom attached segment font-content"><?php echo bbcode_to_html($row['description']); ?></div>
    </div>
  </div>
  <?php if($row['input']){ ?>
    <div class="row">
      <div class="column">
          <h4 class="ui top attached block header"><?php echo $MSG_Input?></h4>
          <div class="ui bottom attached segment font-content"><?php echo bbcode_to_html($row['input']); ?></div>
      </div>
    </div>
  <?php }?>
  <?php if($row['output']){ ?>
    <div class="row">
        <div class="column">
          <h4 class="ui top attached block header"><?php echo $MSG_Output?></h4>
          <div class="ui bottom attached segment font-content"><?php echo bbcode_to_html($row['output']); ?></div>
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
          <h4 class="ui top attached block header"><?php echo $MSG_Sample_Input?> 
          <span class="copy" id="copyin" data-clipboard-text="<?php echo htmlentities($sinput, ENT_QUOTES, 'UTF-8'); ?>"><?php echo $MSG_COPY; ?></span>
          </h4>
          <!-- <span class=copy id=\"copyin\" data-clipboard-text=\"".($sinput)."\"><?php echo $MSG_COPY; ?></span> -->
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
          <h4 class="ui top attached block header"><?php echo $MSG_Sample_Output?>
          <span class="copy" id="copyout" data-clipboard-text="<?php echo htmlentities($soutput, ENT_QUOTES, 'UTF-8'); ?>"><?php echo $MSG_COPY; ?></span>
          </h4>
          <!-- <span class=copy id=\"copyout\" data-clipboard-text=\"".($soutput)."\"><?php echo $MSG_COPY; ?></span> -->
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
          <h4 class="ui top attached block header"><?php echo $MSG_HINT?></h4>
          <div class="ui bottom attached segment font-content hint"><?php echo bbcode_to_html($row['hint']); ?></div>
        </div>
    </div>
  <?php }?>
  <?php
    $color=array("blue","teal","orange","pink","olive","red","violet","yellow","green","purple");
    $tcolor=0;
  ?>
  <?php if($row['source'] && !isset($_GET['cid']) ){
    $cats=explode(" ",$row['source']);
  ?>
    <div class="row">
      <div class="column">
        <h4 class="ui block header top attached" id="show_tag_title_div" style="margin-bottom: 0; margin-left: -1px; margin-right: -1px; ">
        <?php echo $MSG_SOURCE?>
        </h4>
        <div class="ui bottom attached segment" id="show_tag_div">

          <?php foreach($cats as $cat){
            if(trim($cat)=="") continue;
            $label_theme=$color[$tcolor%count($color)];
            $tcolor++;
            ?>
            <a href="<?php
                if(mb_ereg("^http",$cat))    // remote oj pop links
                        echo htmlentities($cat,ENT_QUOTES,'utf-8').'" target="_blank' ;
                else
                        echo "problemset.php?search=".htmlentities($cat,ENT_QUOTES,'utf-8') ;
            ?>" class="ui medium <?php echo $label_theme; ?> label">
              <?php echo htmlentities($cat,ENT_QUOTES,'utf-8'); ?>
            </a>
          <?php } ?>


        </div>
      <div class="ui buttons">

          <?php
            if($pr_flag){
              echo "<a id='submit'  class=\"small ui primary button\" href=\"submitpage.php?id=$id\">$MSG_SUBMIT</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$id\">$MSG_SUBMIT_RECORD</a>";
              echo "<a class=\"small ui orange button\" href=\"problemstatus.php?id=$id\">$MSG_STATISTICS</a>";
	      if($OJ_BBS)echo "<a class=\"small ui red button\" href=\"discuss.php?pid=$id\">$MSG_BBS</a>";
            }else{
              echo "<a href=\"contest.php?cid=$cid\" class=\"ui orange button\">$MSG_RETURN_CONTEST</a>";
              echo "<a id='submit'  class=\"small ui primary button\" href=\"submitpage.php?cid=$cid&pid=$pid&langmask=$langmask\">$MSG_SUBMIT</a>";
              echo "<a class=\"small ui positive button\" href=\"status.php?problem_id=$PID[$pid]&cid=$cid\">$MSG_SUBMIT_RECORD</a>";
            }
	      echo "<a class='small ui primary button' href='#' onclick='transform()' role='button'>$MSG_SHOW_OFF</a>";
          ?>
          
      </div>
      </div>
    </div>
  <?php } ?>
  
    
</div>

  <script type="text/javascript">
  
  function transform(){
        let height=document.body.clientHeight;
<?php if ( $row[ 'spj' ]==2 ) {?>
			let width=parseInt(document.body.clientWidth*0.3);
			let width2=parseInt(document.body.clientWidth*0.7);
<?php }else{ ?>
			let width=parseInt(document.body.clientWidth*0.6);
			let width2=parseInt(document.body.clientWidth*0.4);
<?php } ?>
        let submitURL=$("#submit")[0].href;
        console.log(width);
        let main=$("#main");
        let problem=main.html();
        if (window.screen.width < 500){
        	main.parent().append("<div id='submitPage' class='container' style='opacity:0.8;z-index:1000;top:49px;'></div>");
                $("#submitPage").html("<iframe id='ansFrame' src='"+submitURL+"&spa' width='100%' height='"+window.screen.height+"px' ></iframe>");
                window.setTimeout('$("#ansFrame")[0].scrollIntoView()',1000);
	}else{
        	main.removeClass("container");
		main.css("width",width2);
		main.css("margin-left","10px");
       	 	main.parent().append("<div id='submitPage' class='container' style='opacity:0.8;position:fixed;z-index:1000;top:49px;right:-"+width2+"px'></div>");
		$("#submitPage").html("<iframe src='"+submitURL+"&spa' width='"+width+"px' height='"+height+"px' ></iframe>");
	}
  }

  function submit_code() {
    if (!$('#submit_code input[name=answer]').val().trim() && !editor.getValue().trim()) return false;
    $('#submit_code input[name=language]').val($('#languages-menu .item.active').data('value'));
    lastSubmitted = editor.getValue();
    $('#submit_code input[name=code]').val(editor.getValue());
    return true;
  }

 // $('#languages-menu')[0].scrollTop = $('#languages-menu .active')[0].offsetTop - $('#languages-menu')[0].firstElementChild.offsetTop;

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
<?php if(isset($OJ_MARKDOWN)&&$OJ_MARKDOWN){ ?>
                        $("div.md").each(function(){
                                $(this).html(marked.parse($(this).text()));
                        });
<?php } ?>

  });
  </script>   


  <script>
    var clipboardin=new Clipboard(copyin);
    clipboardin.on('success', function(e){
      $("#copyin").text("<?php echo $MSG_COPY.$MSG_SUCCESS; ?>!"); 
          setTimeout(function () {$("#copyin").text("<?php echo $MSG_COPY; ?>"); }, 1500);    
      console.log(e);
    });
    clipboardin.on('error', function(e){
      $("#copyin").text("<?php echo $MSG_COPY.$MSG_FAIL; ?>!"); 
          setTimeout(function () {$("#copyin").text("<?php echo $MSG_COPY; ?>"); }, 1500);
      console.log(e);
    });

    var clipboardout=new Clipboard(copyout);
    clipboardout.on('success', function(e){
      $("#copyout").text("<?php echo $MSG_COPY.$MSG_SUCCESS; ?>!"); 
          setTimeout(function () {$("#copyout").text("<?php echo $MSG_COPY; ?>"); }, 1500);    
      console.log(e);
    });
    clipboardout.on('error', function(e){
      $("#copyout").text("<?php echo $MSG_COPY.$MSG_FAIL; ?>!"); 
          setTimeout(function () {$("#copyout").text("<?php echo $MSG_COPY; ?>"); }, 1500);
      console.log(e);
    });

  </script>
<?php if (isset($OJ_MATHJAX)&&$OJ_MATHJAX){?>
    <!--以下为了加载公式的使用而既加入-->
<script>
  MathJax = {
    tex: {inlineMath: [['$', '$'], ['\\(', '\\)']]}
  };
</script>

<script id="MathJax-script" async src="template/bs3/tex-chtml.js"></script>
<style>
.jumbotron1{
  font-size: 18px;
}
</style>

<?php } ?>
