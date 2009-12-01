function checkIsChinese(str){  
	 //如果值为空，通过校验  
	 if   (str   ==   "")  
	         return   true;  
	 var   pattern   =   /^([\u4E00-\u9FA5]|[\uFE30-\uFFA0])*$/gi;  
	 if   (pattern.test(str))  
	         return   true;  
	 else  
	         return   false;  
}
function checksource(src){
		var keys=new Array();
		var errs=new Array();
		var msg="";
		keys[0]="void main";
		errs[0]="main函数返回值不能为void,否则会编译出错。\n很多人甚至市面上的一些书籍，都使用了void main( ) ，其实这是错误的。\nC/C++ 中从来没有定义过void main( ) 。\nC++ 之父 Bjarne Stroustrup 在他的主页上的 FAQ 中明确地写着\n The definition void main( ) { /* ... */ } is not and never has been C++,\n nor has it even been C.\n（ void main( ) 从来就不存在于 C++ 或者 C ）。";
		keys[1]="Please";
		errs[1]="除非题目要求，否则不要使用类似‘Please input’这样的提示，";		
		keys[2]="请";
		errs[2]="除非题目要求，否则不要使用类似‘请输入’这样的提示，";		
		keys[3]="输入";
		errs[3]="除非题目要求，否则不要使用类似‘请输入’这样的提示，";		
		keys[3]="input";
		errs[3]="除非题目要求，否则不要使用类似‘Please input’这样的提示，";		
		for(var i=0;i<keys.length;i++){
			if(src.indexOf(keys[i])!=-1){
				msg+=errs[i]+"\n";
			}
		}
		if(msg.length>0)
			return confirm(msg+"\n 代码可能有错误，确定要提交么？");					
		else
			return true;
}