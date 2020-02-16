<?php 
require("./template/$OJ_TEMPLATE/theme.conf.php");?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=auto" />

<!-- KaTeX核心css，不启用 -->
<!--link href="https://cdn.bootcss.com/KaTeX/0.10.2/katex.min.css" rel="stylesheet"-->

<!-- Bootstrap4核心css -->
<link href="https://cdn.bootcss.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<!-- iconfont图标css -->
<link href="//at.alicdn.com/t/font_1198024_t50akptjdvl.css" rel="stylesheet">

<!-- Shards核心文件 -->
<link id="shardsop" rel="stylesheet" href="/template/bshark/shards/dist/css/shards.min.css">

<!-- 主题核心css文件（light and dark） -->
<link href="./template/bshark/main-<?php echo $THEME_MOD;?>.css" rel="stylesheet">

<!-- Highlightjs 核心文件 -->
<link href="https://cdn.bootcss.com/highlight.js/8.0/styles/tomorrow.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/highlight.js/8.0/highlight.min.js"></script>

<!-- Jquery核心文件 -->
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script>
hljs.initHighlightingOnLoad();
</script>

<!-- ChartJs 核心文件 -->
<script src="https://cdn.bootcss.com/Chart.js/2.7.3/Chart.bundle.js"></script>
