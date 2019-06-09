#summary how to add programming language to hustoj.
#labels Featured,Phase-Implementation

= Introduction =

Python for example


= Details =
  
 * write A+B problem solution in this language.
```
#!/usr/bin/python
a=input()
b=input()
print a+b
```

 * strace to check minimal syscalls,if you want 32-bits do it under 32-bits ,if you want a 64-bits do it under 64-bits too.
```
strace -ff python Main.py 2>&1|awk -F\( '{print $1}'|sort -u

output like:

access
......
write
```
 * copy the calls names to add new arrays in to okcallsXX.h,remember to add twice for 32/64-bits x86,armhf,mips, like r747
```
int LANG_YV[256]={SYS_access,SYS_write.....};
int LANG_YC[256]={-1,-1,......,0};
#else
int LANG_YV[256]={};
int LANG_YC[256]={0};
```

 * edit judge_client.cc
   * lang_ext add new ext for lang , "py" for python,r749
   * init_syscalls_limits add new route for python,r750
   * compile or chmod for python, r751
   * add void copy_python_runtime(char * work_dir),if there is a vm or runtime libs needed to copy into chroot dir. use "whereis python" "ldd /usr/bin/python" to locate the files,r752,r761
   * add python run command in run_solution(),r753-r756
 * recompile core using make.sh
 * add a new problem to test new language
 * submit the solution with an exist language
 * modify database to set language=6 and rejudge

update solution set language=6,result=0 where solution_id=2028;

 * if encounted CE or RE debug with 

judge_client 2028 0 /home/judge debug

 * if you finally get AC on the A+B problem showed "Other Language", continue for web.

 * web/include/const.inc.php add "Python" before "Other Language"
 https://github.com/zhblue/hustoj/blob/master/trunk/web/include/const.inc.php#L10
 * web/include/const.inc.php add "py" in "language_ext" array
 https://github.com/zhblue/hustoj/blob/master/trunk/web/include/const.inc.php#L11
 
