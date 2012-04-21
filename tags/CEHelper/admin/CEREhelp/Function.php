<?
/*
*	函数库
*/


function MatchCompileErr( $strError )
{
	//1. 从数据库中获取用于判断编译错误的正则表达式，存在数组$aryRegexCompile
	//2. 将$strError和$aryRegexCompile的每项匹配，找出错误行数，并翻译错误代码。将错误行数放在$aryLineErr，错误代码存于$aryErr。
}

/*
*	匹配编译错误
*/
function MatchCompileErr( $strError, $aryRegex, &$aryLineErr, &$aryErr )
{
	
	foreach($r in $aryRegex)
	{
		if(Match())
		{
		
		}
	}
}


/*
*	匹配
*/
function Match( $strError, $strRegex )
{
	if()
		return false;
	return true;
}





/*
* 抄来的。。。。 
*/


/**
 * 去除多余的转义字符
 */
function doStripslashes(){
	if (get_magic_quotes_gpc()){
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value){
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

?>
