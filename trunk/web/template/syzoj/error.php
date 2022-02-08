<?php 
  $show_title="$MSG_ERROR_INFO - $OJ_NAME";
  include("template/$OJ_TEMPLATE/header.php");
?>
<div class="ui negative icon message">
  <i class="remove icon"></i>
  <div class="content">
    <div class="header" style="margin-bottom: 10px; ">
      <?php echo $view_errors;?>
    </div>
      <!-- <p><%= err.details %></p> -->
    <p>
      <!-- <a href="<%= err.nextUrls[text] %>" style="margin-right: 5px; "><%= text %></a> -->
      <a href="javascript:history.go(-1)"><?php echo $MSG_BACK;?></a>
    </p>
  </div>
</div>

<?php include("template/$OJ_TEMPLATE/footer.php");?>
