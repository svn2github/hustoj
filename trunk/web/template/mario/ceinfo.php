<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $view_title?></title>
	<link rel=stylesheet href='./template/<?php echo $OJ_TEMPLATE?>/mario.css' type='text/css'>
</head>
<body>
<div id="wrapper">
	<?php require_once("oj-header.php");?>
<div id=main>
	
<pre id='errtxt'><?php echo $view_reinfo?></div>
<div id='errexp'>Explain:</div>

<script>
   var pats=new Array();
   var exps=new Array();
   pats[0]=/warning.*declaration of 'main' with no type/;
   exps[0]="C++标准中，main函数必须有返回值";
   pats[1]=/'.*' was not declared in this scope/;
   exps[1]="变量没有声明过，检查下是否拼写错误！";
   pats[2]=/main’ must return ‘int’/;
   exps[2]="在标准C语言中，main函数返回值类型必须是int，教材和VC中使用void是非标准的用法";
   pats[3]=/ .* was not declared in this scope/;
   exps[3]="函数或变量没有声明过就进行调用，检查下是否导入了正确的头文件";
   pats[4]=/printf.*was not declared in this scope/;
   exps[4]="printf函数没有声明过就进行调用，检查下是否导入了stdio.h或cstdio头文件";
   pats[5]=/ warning: ignoring return value of/;
   exps[5]="警告：忽略了函数的返回值，可能是函数用错或者没有考虑到返回值异常的情况";
   pats[6]=/:.*__int64’ undeclared/;
   exps[6]="__int64没有声明，在标准C/C++中不支持微软VC中的__int64,请使用long long来声明64位变量";
   pats[7]=/:.*expected ‘;’ before/;
   exps[7]="前一行缺少分号";
   pats[8]=/ .* undeclared \(first use in this function\)/;
   exps[8]="变量使用前必须先进行声明，也有可能是拼写错误，注意大小写区分。";
   pats[9]=/scanf.*was not declared in this scope/;
   exps[9]="scanf函数没有声明过就进行调用，检查下是否导入了stdio.h或cstdio头文件";
   pats[10]=/memset.*was not declared in this scope/;
   exps[10]="memset函数没有声明过就进行调用，检查下是否导入了stdlib.h或cstdlib头文件";
   pats[11]=/malloc.*was not declared in this scope/;
   exps[11]="malloc函数没有声明过就进行调用，检查下是否导入了stdlib.h或cstdlib头文件";
   pats[12]=/puts.*was not declared in this scope/;
   exps[12]="puts函数没有声明过就进行调用，检查下是否导入了stdio.h或cstdio头文件";
   pats[13]=/gets.*was not declared in this scope/;
   exps[13]="gets函数没有声明过就进行调用，检查下是否导入了stdio.h或cstdio头文件";
   pats[14]=/str.*was not declared in this scope/;
   exps[14]="string类函数没有声明过就进行调用，检查下是否导入了string.h或cstring头文件";
   pats[15]=/‘import’ does not name a type/;
   exps[15]="不要将Java语言程序提交为C/C++,提交前注意选择语言类型。";
   pats[16]=/asm’ undeclared/;
   exps[16]="不允许在C/C++中嵌入汇编语言代码。";
   pats[17]=/redefinition of/;
   exps[17]="函数或变量重复定义，看看是否多次粘贴代码。";
   pats[18]=/expected declaration or statement at end of input/;
   exps[18]="程序好像没写完，看看是否复制粘贴时漏掉代码。";
   pats[19]=/warning: unused variable/;
   exps[19]="警告：变量声明后没有使用，检查下是否拼写错误，误用了名称相似的变量。";
   pats[20]=/implicit declaration of function/;
   exps[20]="函数隐性声明，检查下是否导入了正确的头文件。";
   pats[21]=/too .* arguments to function/;
   exps[21]="函数调用时提供的参数数量不对，检查下是否用错参数。";
   pats[22]=/expected ‘=’, ‘,’, ‘;’, ‘asm’ or ‘__attribute__’ before ‘namespace’/;
   exps[22]="不要将C++语言程序提交为C,提交前注意选择语言类型。";
   pats[23]=/stray ‘\\[0123456789]*’ in program/;
   exps[23]="中文空格、标点等不能出现在程序中注释和字符串以外的部分。";
   pats[24]=/division by zero/;
   exps[24]="除以零将导致浮点溢出。";
   pats[25]=/cannot be used as a function/;
   exps[25]="变量不能当成函数用，检查变量名和函数名重复的情况，也可能是拼写错误。";
   pats[26]=/format .* expects type .* but argument .* has type .*/;
   exps[26]="scanf/printf的格式描述和后面的参数表不一致，检查是否多了或少了取址符“&”，也可能是拼写错误。";
   
   function explain(){
     //alert("asdf");
       var errmsg=document.getElementById("errtxt").innerHTML;
	   var expmsg="辅助解释：<br>";
	   for(var i=0;i<pats.length;i++){
		   var pat=pats[i];
		   var exp=exps[i];
		   var ret=pat.exec(errmsg);
		   if(ret){
		      expmsg+=ret+":"+exp+"<br>";
		   }
	   }
	   document.getElementById("errexp").innerHTML=expmsg;
     //alert(expmsg);
   }
   explain();
 
 </script>
<div id=foot>
	<?php require_once("oj-footer.php");?>

</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
</body>
</html>
