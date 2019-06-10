<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE/"?>bootstrap.min.js"></script>

<?php
if(file_exists("./admin/msg.txt"))
$view_marquee_msg=file_get_contents($OJ_SAE?"saestor://web/msg.txt":"./admin/msg.txt");
if(file_exists("../admin/msg.txt"))
$view_marquee_msg=file_get_contents($OJ_SAE?"saestor://web/msg.txt":"../admin/msg.txt");


?>
<!--  to enable mathjax in hustoj:
svn export http://github.com/mathjax/MathJax/trunk /home/judge/src/web/mathjax
<script type="text/javascript"
  src="mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
or
<script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>

-->
<script>
$(document).ready(function(){
  var msg="<marquee style='margin-top:10px' id=broadcast direction='left' scrollamount=3 scrolldelay=50 onMouseOver='this.stop()'"+
      " onMouseOut='this.start()' class=toprow>"+<?php echo json_encode($view_marquee_msg); ?>+"</marquee>";
  $(".jumbotron").prepend(msg);
  $("form").append("<div id='csrf' />");
  $("#csrf").load("<?php echo $path_fix?>csrf.php");
  $("body").append("<div id=footer class=center >GPLv2 licensed by <a href='https://github.com/zhblue/hustoj' >HUSTOJ</a> "+(new Date()).getFullYear()+" </div>");
  $("body").append("<div class=center > <img src='http://hustoj.com/wx.jpg' width='120px'><img src='http://hustoj.com/alipay.png' width='120px'><br> 欢迎关注微信公众号onlinejudge</div>");
  <?php 
	if(isset($_SESSION[$OJ_NAME."_administrator"])) echo "admin_mod();";
  ?>
});

$(".hint pre").each(function(){
	var plus="<span class='glyphicon glyphicon-plus'>Click</span>";
	var content=$(this);
	$(this).before(plus);
	$(this).prev().click(function(){
		content.toggle();
	});
	
});

  console.log("If you want to change the appearance of the web pages, make a copy of bs3 under template directory.\nRename it to whatever you like, and change the $OJ_TEMPLATE value in db_info.inc.php\nAfter that modify files under your own directory .\n");
  console.log("To enable mathjax in hustoj, check line 15 in /home/judge/src/web/template/bs3/js.php");
function admin_mod(){
	$("div[fd=source]").each(function(){
		let pid=$(this).attr('pid');	
		$(this).append("<span><span class='label label-success' pid='"+pid+"' onclick='problem_add_source(this,"+pid+");'>+</span></span>");

	});
}
function problem_add_source(sp,pid){
	console.log("pid:"+pid);
	let p=$(sp).parent();
	p.html("<form><input type='hidden' name='m' value='problem_add_source'><input type='hidden' name='pid' value='"+pid+"'><input type='text' class='input input-large' name='ns'></form>");
	p.find("input").focus();
	p.find("input").change(function(){
		console.log(p.find("form").serialize());
		let ns=p.find("input[name=ns]").val();
		console.log("new source:"+ns);
		$.get("admin/ajax.php",p.find("form").serialize());
		p.parent().append("<span class='label label-success'>"+ns+"</span>");
		p.html("<span class='label label-success' pid='"+pid+"' onclick='problem_add_source(this,"+pid+");'>+</span>");
	});
}
</script>

