<?php
  $show_title="$MSG_ERROR_INFO - $OJ_NAME";
  include(dirname(__FILE__)."/header.php");
?>
<div class="ui negative icon message">
  <i class="remove icon"></i>
  <div class="content">
    <div class="header" style="margin-bottom: 10px; " ondblclick='$(this).load("refresh-privilege.php")'>
      <?php echo $view_errors;?>
      <?php if ($OJ_LANG=="cn") echo "<br>如果你是管理员，希望解决这个问题，请打开<a href='http://hustoj.com' target='_blank'>HUSTOJ常见问题</a>，按Ctrl+F查找上面错误信息中的关键词。";?>
    </div>
      <!-- <p><%= err.details %></p> -->
    <p>
      <!-- <a href="<%= err.nextUrls[text] %>" style="margin-right: 5px; "><%= text %></a> -->

      <a href="javascript:history.go(-1)"><?php echo $MSG_BACK;?></a>
    </p>
  </div>
</div>

<?php include(dirname(__FILE__)."/footer.php");?>
