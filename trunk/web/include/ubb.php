<?
function ubb($content){
$content = preg_replace("#\[code\](.*?)\[/code]#si","<table border=0 width=90% cellspacing=1 cellpadding=0 align=center>  <tr><td><strong>引用 or 代码：</strong></td></tr><tr><td><table width=100% border=0 cellpadding=5 cellspacing=1 bgcolor=#999999><tr><td width=100% bgcolor=#FFFFFF style=word-break:break-all id=code>\\1</td></tr></table></td></tr></table>", $content);
$content = str_replace("[b]","<b>",$content);
$content = str_replace("[/b]","</b>",$content);
$content = str_replace("[i]","<i>",$content);
$content = str_replace("[/i]","</i>",$content);
$content = str_replace("[u]","<u>",$content);
$content = str_replace("[/u]","</u>",$content);
$content = str_replace("[list]","<ul>",$content);
$content = str_replace("[/list]","</ul>",$content);
$content = str_replace("[*]","<li>",$content);
$content = str_replace("[align=center]","<div align=center>",$content);
$content = str_replace("[/align]","</div>",$content);
$content = eregi_replace("\[img]([^\\[]*)\[/img\]", "<a href=\"\\1\" target=\"_blank\"><img src=\"\\1\" border=\"0\" alt=在新窗口浏览图片 onload=\"javascript:if(this.width>500)this.width=500\"></a>", $content);
$content = eregi_replace("\\[swf\\](.+\.swf)\\[/swf\\]","<PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><embed src=\"\\1\" quality=high pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave-flash\" width=\"280\" height=\"140\"></embed><br><a href=\"\\1\" target=_blank>左键全屏观赏</a>",$content);
$content =preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><table width=\"80%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCCC\" align=\"center\"><tr><td bgcolor=\"#F2F2F2\" height=\"40\">\\1</td></table>&nbsp;</blockquote>",$content);
$content = preg_replace('#\[url]([a-z]+?://){1}(.*?)\[/URL]#', '<a href="\1\2" target=_blank>$1$2</a>', $content);
$content = preg_replace('#\[url](.*?)\[/url\]#', '<a href=http://\1\2 target=_blank>\1</a>', $content);
$content = preg_replace('#\[url=([a-z]+?://){1}(.*?)\](.*?)\[/url]#', '<a href="\1\2" target=_blank>\3</a>', $content);
$content = preg_replace( "#\[email\](\S+?)\[/email\]#i","<a href=\"email.php?e=\\1\" title=\"这里是一个邮件地址,点击可以直接发信!\" target=\"_blank\">点击直接发信</a>",$content);
$content = preg_replace( "#\[email\s*=\s*\&quot\;([\.\w\-]+\@[\.\w\-]+\.[\.\w\-]+)\s*\&quot\;\s*\](.*?)\[\/email\]#i","<a href='mailto:\1'>\\2</a>",$content);
$content = preg_replace( "#\[email\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/email\]#i","<a href='mailto:\\1'>\\2</a>",$content);
$content = preg_replace("#\[center\](.+?)\[/center\]#is","<center>\\1</center>",$content);
$content = preg_replace("#\[left\](.+?)\[/left\]#is","<div align=left>\\1</div>",$content);
$content = preg_replace("#\[right\](.+?)\[/right\]#is","<div align=right>\\1</div>",$content);
return $content;
}
?> 
