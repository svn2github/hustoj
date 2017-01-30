hustoj
======
微信公众号:hustoj
![image](http://hustoj.com/wx.jpg)

HUSTOJ is an GPL FreeSoftware?.

HUSTOJ 是采用GPL的自由软件。

因googlecode受阻，最新更新迁移至此。

注意：基于本项目源码从事科研、论文、系统开发，"最好"在文中或系统中表明来自于本项目的内容和创意，否则所有贡献者可能会鄙视你和你的项目。
使用本项目源码和freeproblemset题库请尊重程序员职业和劳动

PS: GPL保证你可以合法忽略以上注意事项但不能保证你不受鄙视，呵呵。


Ubuntu14.04快速安装指南：
(16.04见https://github.com/zhblue/hustoj/tree/php7)

    1、安装Ubuntu 14.04 LTS  (16.04 need the php7 branch)
    2、执行如下命令
        sudo apt-get update
        sudo apt-get install subversion
        sudo svn co https://github.com/zhblue/hustoj/trunk/trunk/install hustoj
        cd hustoj
        sudo bash install-interactive.sh
    3、安装后访问服务器80端口上的web服务JudgeOnline目录
        例如 w3m http://127.0.0.1/JudgeOnline
        
使用上需要帮助，请访问用户论坛 或 购买在线服务。

Linux新手请看鸟哥的私房菜http://vbird.dic.ksu.edu.tw/linux_basic/linux_basic.php

Linux不熟悉的用户推荐使用HUSTOJ_LiveCD或HUSTOJ_Windows进行安装

livecd下载: 

http://pan.baidu.com/s/1o78D4x0  无vjudge，含vjudge版见qq群23361372共享文件。



使用说明见iso中README,也可以参考wiki页
https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md


用户交流qq群23361372,验证信息freeproblemset； 缺少Linux知识的请加高级服务收费群http://t.cn/SyNZhV

或者使用GoogleGroups?(需要某种特殊程序) nonChina users forum : http://groups.google.com/group/hustoj

提供hustoj判题服务的虚拟主机，只需10元每月。

Any Question check wiki first.有问题请先查阅Wiki或使用搜索。

目前维护者 newsclan@gmail.com http://blog.csdn.net/zhblue/
最新更新
	Schema CLang/CLang++ lua nodejs golang
    自定义数据运行的在线IDE模式。
    FreeBasic? (32bits only)，测试中
    Objective-C，测试中
    Ajax结果查看，免刷新看提交结果
    多进程优化，判题提速100%
    邮件密码找回，需要安装sendmail或其他MTA
    类Android越狱漏洞修补
    Moodle离线作业自动批阅触发器(群共享)
    Moodle账号登陆、Disucz账号登陆
    腾讯、新浪微博、人人账号登陆
    编译错误、运行错误辅助分析
    测试数据在线管理：web方式维护测试数据
    附加代码模式：可以给指定语言的提交指定附加代码，用于要求学生编写指定函数、类供附加代码调用。
    OiMode 支持OI模式，显示测试数据通过率
    memcached/file cache all pages
    http判题端，移植到新浪云http://hustoj.sinaapp.com/
    分时段排名 日周月年
    status防刷缓存
    简单内部邮件系统
    代码共享机制OJ_AUTO_SHARE
    用户下载所有AC代码
    提交界面代码亮显
    SQL注入漏洞修补
    比赛队帐号批量生成工具
    首页新闻编辑管理
    系统级语言掩码，可系统级屏蔽答题语言。
    Ruby、Bash、Python、Perl、C#、PHP 答题功能测试中 http://hustoj.sinaapp.com/
    多语言 MultiLanguage? 한국어 中文 فارسی English ไทย 

HUSTOJ特性

    开源 全部采用开源技术，不仅仅是提供源代码，搭建HUSTOJ?不需要购买任何商业软件。
    采用成熟的Linux32/64位系统平台，通过目录锁定和用户锁定以及系统调用限制避免恶意答案损害系统。
    支持负载均衡，可以将web服务器、数据库服务器、判题服务器分机架设，支持多台判题服务器同时工作。
    支持单台服务器运行多个实例，即单机运行多套OJ互不影响，可降平均低运行成本。
    管理员可以完全通过web平台添加题目，包括测试数据也可以同时添加。
    加题界面采用kindeditor界面，支持从Word / 网页复制粘贴，支持各种格式，可以上传图片。
    提供源码查看支持C/C++/Java代码亮显。
    比赛可以快速复制，题目自动添加。
    比赛可限定语言种类，用于课程练习﹑考试。
    题目、数据、标程，均可批量导出、导入，采用公开的基于XML的FPS格式，方便导入其他OJ系统，方便学校联赛交换题目。单场比赛用题可以快捷导出。
    题目﹑用户提交历史统计饼图显示。
    支持内置和外挂论坛系统。
    FPS项目提供400余道题目，导入就可以用于教学、比赛、测试。
    极低的系统需求，曾在C-600/128M/15G的老爷机上无故障运行一年，期间完成多次校赛。
    可以由POJ免费版转换，能够保留全部题目、帐号、历史数据。浙江工商大学POJ服务器崩溃后成功升级到HUSTOJ
    界面本地化，中英韩可用。
    原生支持64位系统 amd64/x86-64bit (beta)
    支持反作弊功能，提示管理者相似答案。
    提供LiveCD系统，无须安装即可试用。 

Who Used the System

发源地：

    华中科技大学 上线时间 2008年5月14日 

LiveCD iso 下载 https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md

需要邮寄LiveCD光盘可以访问 淘宝链接，高校教师购买可享受8折优惠。 


--------请人类浏览者忽略以下信息--------

引诱爬虫实验，请勿点击。http://book.taoshell.com/
