<?php 
	$dir=basename(getcwd());
	if($dir=="discuss3"||$dir=="admin") $path_fix="../";
	else $path_fix="";
?>
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/style.css">
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/tomorrow.css">
<link rel="stylesheet" href="<?php echo $path_fix."template/$OJ_TEMPLATE"?>/css/semantic.min.css">
<link rel="stylesheet" href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/katex.min.css">
<script defer src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/katex.js"></script>
<script>
var katex_config = {
	delimiters: 
	[
		{left: "$$", right: "$$", display: true},
  		{left: "$", right: "$", display: false}
	]
};
</script>
<script defer src="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/auto-render.min.js" onload="renderMathInElement(document.body, katex_config)"></script>
<link href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/morris.min.css" rel="stylesheet">
<link href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/FiraMono.css" rel="stylesheet">
<link href="<?php echo $path_fix."template/$OJ_TEMPLATE"?>/css/latin.css" rel="stylesheet">
<link href="<?php echo $OJ_CDN_URL.$path_fix."template/$OJ_TEMPLATE"?>/css/latin-ext.css" rel="stylesheet">
<link href="<?php echo $path_fix."template/$OJ_TEMPLATE"?>/css/Exo.css" rel="stylesheet">
