#summary Special Judger usage in hustoj
#labels Featured,Phase-Support,Special-Judge

= Introduction =

sometimes,thers are more than one possible output for one test case.

a program which called special judger is needed for judging the result.


= Details =

HUSTOJ support SPJ.

you can put a program name spj (set execute mode) in data dir of the problem.

and if you want to be able to export it, you should provide a source file name spj.c or spj.cc,too

this program take 3 parameters when running,which is "test input file" , "test output file", and "users output file".

the result is returned by spj process with exit code, an 0 exit value means AC, and others means WA.

spj的文件可以是c或cpp编写的程序，编译为spj文件，并设执行权限。

spj.c 或 spj.cc，需编译为spj，执行spj时传3个文件名参数：输入，参考输出，用户输出。

spj.c 或 spj.cc 应放置于对应题目测试数据目录下，导出题目时将自动导出 。

* 执行判定是自动的。

spj的退出值决定判断结果，成功退出(0)表示AC,其余表示WA.

把spj本身看做一道题目，输入是前述三个文件，输出是程序退出时的返回值,返回值是0表示AC,非零表示WA。

可以到freepeoblemset找到标有Spj的题目下载


A+B spj.c

 #include <stdio.h>
 int main(int argc,char *args[]){
   FILE * f_in=fopen(args[1],"r");
   FILE * f_out=fopen(args[2],"r");
   FILE * f_user=fopen(args[3],"r");
   int ret=0;
   int a,b,c;
   while(fscanf(f_in,"%d %d",&a, &b) != EOF){
     fscanf(f_user,"%d",&c);
     if(a+b!=c) {
        ret=1;
        break;
     }
   }
   fclose(f_in);
   fclose(f_out);
   fclose(f_user);
   return ret;
 }

