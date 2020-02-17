<!-- KaTeX核心js -->
<!--script src="https://cdn.bootcss.com/KaTeX/0.10.2/katex.min.js"></script-->
<!--script src="https://cdn.bootcss.com/KaTeX/0.10.2/contrib/auto-render.min.js"></script-->

<!-- WangEditor编辑器文件-->
<script src="./template/bshark/wangEditor/wangEditor.min.js"></script>

<!-- Bootstrap4 和 shards -->
<script src="./template/bshark/bootstrap4/js/bootstrap.min.js"></script>
<script src="./template/bshark/shards/js/shards.min.js"></script>

<!-- 主题核心js -->
<?php 
$url=basename($_SERVER['REQUEST_URI']);
$realurl=basename($_SERVER['REQUEST_URI']);
$url=str_replace(strrchr($url, "?"),"",$url); 
if ($url != 'loginpage.php' && $url != 'registerpage.php') { ?>
<script src="./template/bshark/main.js"></script>
<?php } ?>

<!-- KaTeX AutoRender 开启后用$就能引用数学公式 -->
<!--script>
    renderMathInElement(document.body,
   {
              delimiters: [
                  {left: "$$", right: "$$", display: true},
                  {left: "$", right: "$", display: false}
              ]
          }
  );
</script-->
