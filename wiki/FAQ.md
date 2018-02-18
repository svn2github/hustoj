#summary FAQ常见问答
#labels Featured,FAQ

= Introduction =

When people asked question, we put the answer here

这里是常见问答。

= Details =

* 编译报错找不到mysql.h

    如果使用debian或centos，可能默认安装的是mariadb不是mysql，这时请自行搜索安装mariadb的头文件。
    
debian里大约是
```
    sudo apt-get install libmariadb-dev
```
centos里大约是
```
    sudo yum install MariaDB-devel
```

* Runtime Error:[ERROR] A Not allowed system call: runid:10735 CALLID:20 如何解决？
编辑okcalls64.h或okcalls32.h（取决于您使用的Linux版本uname -a出现x64字样则64位，i686字样则32位），在对应的语言数组里增加内容。
如C或C++：

	int LANG_CV[256] = { 85, 8,140, SYS_time, SYS_read, SYS_uname, SYS_write, SYS_open,
		SYS_close, SYS_execve, SYS_access, SYS_brk, SYS_munmap, SYS_mprotect,
		SYS_mmap2, SYS_fstat64, SYS_set_thread_area, 252, 0 };


将上述报错中CALLID:后的数字，增加到数组中非末尾的位置，如果这个数字是0，请加在首位。

	int LANG_CV[256] = { 20, 85, 8,140, SYS_time, SYS_read, SYS_uname, SYS_write, SYS_open,
		SYS_close, SYS_execve, SYS_access, SYS_brk, SYS_munmap, SYS_mprotect,
		SYS_mmap2, SYS_fstat64, SYS_set_thread_area, 252, 0 };

修改完成，重新在core目录执行sudo ./make.sh
然后重新测试，如果发现再次出现类似错误，请留意CALLID数字变化，重复上述步骤直至问题消失。
看不懂请移步[知乎](https://zhuanlan.zhihu.com/p/24498599) 看更详细解释。


* 如何让判题程序忽略行尾的空白字符

	在judge_client.cc头部增加宏定义 IGNORE_ESOL

* 配置文件里的字段什么含义?

    点击[Configuration](https://github.com/zhblue/hustoj/blob/master/wiki/Configuration.md)
	 
* 多组数据怎么上传？
加好题目后在题目列表找TestData，点击上传。
主文件名一样的*.in *.out，如test1.in test1.out

* 通过.tar.gz源码安装的应该怎么升级？

到安装文件目录找到hustoj-read-only目录
sudo svn up hustoj-read-only
cd hustoj-read-only/core
sudo ./make.sh
sudo svn up /var/www/JudgeOnline

遇到问题，回答mc
   
* 为何页面总是需要刷新才能显示？
    如果您使用的是ie6浏览器，请禁用服务器上的deflate模块，在ubuntu下的命令是

sudo rm /etc/apache2/mods-enabled/deflate.*
sudo /etc/init.d/apache2 restart

* CentOS 用户，点击[CentOS](https://github.com/zhblue/hustoj/blob/master/wiki/CentOS.md)

* 使用HUSTOJ要花多少钱？

    不要钱，我们是GPL的。
    
* 管理员如何添加，如何管理？

    查看安装说明[README],管理员登录后有Admin菜单。

* 为什么我提交的答案始终在pending？

    判题程序judged需要用root帐号启动，请重启服务器或手动执行sudo judged。如果无效，请检查/home/judge/etc/judge.conf中的数据库账号配置,参考[Configuration]，修正后再次重启服务器或执行sudo pkill -9 judged等待一会儿再执行sudo judged

* 为什么添加题目时出现warning,题目目录下数据没有自动生成？


    您需要修改系统php.ini,给予php操作数据目录的权限。
    以下是推荐修改的设置
```
    sudo gedit /etc/php5/fpm/php.ini 
    max_execution_time = 300     ; Maximum execution time of each script, in seconds
    max_input_time = 600 
    memory_limit = 128M      ; Maximum amount of memory a script may consume (16MB)
    post_max_size = 64M
    upload_tmp_dir =/tmp
    upload_max_filesize = 64M
```
    修改php.ini后php-fpm需重启
```
    sudo service php-fpm restart
```     
* 为什么我添加的题目普通用户看不到？

    题目默认为删除状态，只有管理员能访问，当管理员确认题目没有问题后，可以点击ProblemList中红色的Reserved,切换为绿色的Available启用题目。
 
* 为何我的C/C++都能用，唯独Java总是CE/RE？

　　目前只支持sun原版jdk和openjdk，其他jdk暂不能保证支持。如果你用的是64位系统，你可能需要自己调整一下源代码。请联系我。
  
* 我是管理员，为什么不能查看别人的源码？  

    请给自己增加source_browser权限。issue1
    
* 如何更新到最新版本？

    svn up /var/www/JudgeOnline
    或重新运行install.sh
    升级并编译内核make.sh
    然后用管理员登陆，后台执行update_database(更新数据库)。
    
* 如何从POJ的免费版迁移？

    参考[POJ2HUSTOJ]

* 我有问题怎么办？

    到issues去提问，new issue

*   如何获得管理员帐号？

    注册一个叫admin的用户，自动获得权限。

* 如何进入后台？

    以管理员身份登录，点击Admin/管理进入后台。

* 如何添加题目？

    进入后台，点击左侧NewProblem。

* 如何添加测试数据？

    添加题目时，可以在test input/test output添加一组测试数据，大规模的数据（10kb+）和更多的数据，可以在添加完题目后，通过ftp/sftp,上传到题目对应目录，通常是 /home/judge/data/题号。命名规则是输入数据以.in结尾，输出数据以.out结尾，主文件名相同。

* 如何编辑题目？

    后台中点击ProblemList,找到需要编辑的题目，点击Edit。编辑时不能修改测试数据，测试数据请使用ftp工具修改。

* 如何启用题目？

    题目添加后，默认是停用状态，以防比赛提前漏题，后台中点击ProblemList，找到题目，点击Reserved 切换为Available启用题目，或者组织比赛，比赛中的题目将自动启用。

* 如何组织比赛？

    在题目列表ProblemList中选择使用的题目，在PID一栏打钩，点击CheckToNewContest按钮，进入到比赛添加页面，输入比赛名称，设定比赛时间，语言类型，访问权限提交即可。
    也可以使用管理菜单中的NewContest,需要手动输入题目编号，用英文逗号分隔。

* 如何修改、删除比赛？

    点击比赛列表ContestList，选择Edit或Delete。

* 如何修改公告信息？

    点击SetMessage。修改无效请检查admin/msg.txt是否对php账号(www-data)可写

* 如何修改用户密码？

    点击ChangPassWD

* 如何重新判题？

    点击Rejudge,输入题号或运行编号。

* 如何增加用户权限？

    Addprivilege/添加权限, administrator为管理员，source_browser为代码审查，contest_creator为比赛组织者。
    通常给使用系统的老师分配代码审查和比赛组织者权限即可。

* 如何导入、导出题目？

    使用ImportProblem，上传FPS文件。
    使用ExportProblem，输入起始编号，结束编号，或题号列表，如果输入了列表，起始结束将不起作用。

* 如何更新数据库结构？

    系统升级中，有对数据库的修改，这些修改不能通过SVN实现自动更新，如果发现升级web/core代码后系统报错，可以执行update database操作，进行数据库升级。因为脚本中有测试代码，所以重复执行不会造成影响。

* 如何下载新题目？

    访问FreeProblemSet,查看Downloads列表。
    
* 为何fckeditor上传的图片在题目中无法显示？

    如果web安装位置不在/JudgeOnline，需要手工修改

/fckeditor/editor/filemanager/connectors/php/config.php37行
$Config['UserFilesPath'] = '/JudgeOnline/upload/'.date("Ym")."/"  ;

将JudgeOnline修改为对应的OJ web路径,如oj。

* Why the added problem don't show up to non-admin users?
    
    problem is deleted when first added, admin need to Resume them in the "Problem List"
 
* I install hustoj on CentOS, why it doesn't work?
    disable your SELinux and check /etc/php.ini for short_open_tag = On

* Why Java can't work?
    
    Try SUN-JDK or openjdk,if you are working with a 64bit System, check issue25

* How much dollar to get this system ?
  
    0, God bless GPL.
