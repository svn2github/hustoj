<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="<?php echo $path_fix."template/$OJ_TEMPLATE/"?>jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="<?php echo $path_fix."template/$OJ_TEMPLATE/"?>bootstrap.min.js"></script>

<?php
$view_marquee_msg=file_get_contents($OJ_SAE?"saestor://web/msg.txt":"./admin/msg.txt");

?>
<script>
$(document).ready(function(){
  var msg="<marquee  id=broadcast scrollamount=1 scrolldelay=50 onMouseOver='this.stop()' onMouseOut='this.start()' class=toprow><?php echo $view_marquee_msg?></marquee>";
  $(".jumbotron").prepend(msg);
});

</script>

