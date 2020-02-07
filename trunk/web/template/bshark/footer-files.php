<script src="https://cdn.bootcss.com/KaTeX/0.10.2/katex.min.js"></script>
<script src="https://cdn.bootcss.com/KaTeX/0.10.2/contrib/auto-render.min.js"></script>
<script src="https://cdn.bootcss.com/popper.js/1.15.0/esm/popper.min.js"></script>
<script src="https://cdn.bootcss.com/wangEditor/10.0.13/wangEditor.min.js"></script>
<script src="https://cdn.bootcss.com/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="/template/bshark/shards/dist/js/shards.min.js"></script>
<?php 
$url=basename($_SERVER['REQUEST_URI']);
$realurl=basename($_SERVER['REQUEST_URI']);
$url=str_replace(strrchr($url, "?"),"",$url); 
if ($url != 'loginpage.php' && $url != 'registerpage.php') { ?>
<script src="/template/bshark/main.js"></script>
<?php } ?>
<script>
    renderMathInElement(document.body,
   {
              delimiters: [
                  {left: "$$", right: "$$", display: true},
                  {left: "$", right: "$", display: false}
              ]
          }
  );
</script>
