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

新用户必看 README 和 FAQ

    快速安装指南：
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
http://pan.baidu.com/s/1o78D4x0

使用说明见iso中README,也可以参考wiki页
https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md


用户交流qq群23361372,验证信息freeproblemset； 缺少Linux知识的请加高级服务收费群http://t.cn/SyNZhV

或者使用GoogleGroups?(需要某种特殊程序) nonChina users forum : http://groups.google.com/group/hustoj

提供hustoj判题服务的虚拟主机，只需10元每月。

Any Question check wiki first.有问题请先查阅Wiki或使用搜索。

目前维护者 newsclan@gmail.com http://blog.csdn.net/zhblue/
最新更新

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
    采用成熟的Linux32位系统平台，通过目录锁定和用户锁定以及系统调用限制避免恶意答案损害系统。
    支持负载均衡，可以将web服务器、数据库服务器、判题服务器分机架设，支持多台判题服务器同时工作。
    支持单台服务器运行多个实例，即单机运行多套OJ互不影响，可降平均低运行成本。
    管理员可以完全通过web平台添加题目，包括测试数据也可以同时添加。
    加题界面采用fckeditor界面，支持从Word / 网页复制粘贴，支持各种格式，可以上传图片。
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

互联网用户：（基于本站访问数据HTTP Referer）

    浙江传媒学院http://oj.zjicm.acm.zj.cn/ 升级自POJ免费版
    韩国京畿道大学 http://acm.ajou.ac.kr/JudgeOnline/ http://judge.lavida.us
    韩国西江大学http://www.acmicpc.net/JudgeOnline
    香港信息学竞赛网http://judge.oi.hk/
    中国沈阳工程学院http://acm.sie.edu.cn/
    韩国东国大学http://210.94.181.91/JudgeOnline/
    FPS-OJ Demo http://www.newsclan.com/Judgeonline/
    浙江工商大学 升级自POJ免费版 http://acm.zjgsu.edu.cn/JudgeOnline/
    西北工业大学腾讯俱乐部在线评测系统 http://www.nputic.com/
    山东工商学院 http://acm.sdibt.edu.cn/JudgeOnline/
    常州信息学院 http://58.193.10.239/oj/
    马鞍山职业技术学院 http://mastc.acm.zj.cn CentOS system
    MegaJudge? (泰国宋卡王子大学,Prince of Songkla University) http://judge.megagod.net/
    马鞍山市二中实验学校 http://220.178.248.251/JudgeOnline/
    韩国成均馆大学 http://115.145.171.68/index.php
    首尔国立大学http://odin.snu.ac.kr/oj/
    苏州工业园区服务外包职业学院http://learn.siso.edu.cn/
    國立東華大學(台湾)http://134.208.3.122/JudgeOnline/
    东北大学http://acm.neu.edu.cn/
    大视野（原衡阳市八中） http://8zoj.tk/JudgeOnline/
    北里奥格兰德联邦大学(巴西)http://juizonline.ect.ufrn.br/
    國立彰化高中（台湾）http://student.chsh.chc.edu.tw/JudgeOnline/
    黑龙江八一农垦大学http://61.167.199.237:9000/JudgeOnline/
    山东大学SDUOJ http://sduacm.tk
    新浪云平台演示版 http://hustoj.sinaapp.com/
    北京信息科技大学 http://bistuacm.sinaapp.com
    中山大学（台湾） http://140.117.69.104/JudgeOnline/
    九度研究生复试机考历年题 http://ac.jobdu.com/
    马其顿某大学 http://www.koduesi.info/
    成都东软学院 http://acm.nsu.edu.cn/JudgeOnline/
    海青科技 http://acm.hqwiki.cn/
    湖南工业大学 http://218.75.208.59:8084/JudgeOnline/ 从nuaa迁移
    杭州外国语学校 http://it.chinahw.net/JudgeOnline/
    中国地质大学（武汉） http://202.114.196.48/JudgeOnline/
    中南大学 http://acm.csu.edu.cn/OnlineJudge/
    喀山大学 http://88.198.206.54/web/
    杭州师范大学杭州国际服务工程学院 http://ds.imedialab.info/
    重庆八中 http://61.186.173.85/JudgeOnline
    逢甲大学(台湾)http://acm.iecs.tw
    大连理工 http://acm.dlut.edu.cn/
    慈溪中学 http://cxmsoj.sinaapp.com/ http://61.164.90.86:8088/JudgeOnline/
    山东科技大学 http://sdustoj.tk/
    山东大学 BChine http://acm.bchine.com/
    山东师范大学 http://acm.dreamto.me:88/JudgeOnline/ http://sdnuacm.sinaapp.com/
    沈阳工业大学 http://202.199.100.61/JudgeOnline/
    中国矿业大学 http://acm.cumtcs.net/JudgeOnline
    台南二中 http://judge.tnssh.tn.edu.tw
    杨浦区青少年科技站 http://oj.ypskz.com.cn/
    内蒙古工业大学 http://115.24.95.46/JudgeOnline
    华南师大附中 http://oj.hsfz.net.cn/JudgeOnline/
    慈溪胜山中心小学 http://ssedu.cixiedu.net:8004/JudgeOnline/
    华为软件训练营 http://58.60.106.36:9393/web/ http://ilearning.hwclouds.com
    浙江外国语学院 http://60.191.14.100/zisuOJ/
    中原工业学院 http://202.196.35.59/JudgeOnline/
    东南大学 http://jol.seu.edu.cn/
    华南理工大学 http://116.56.142.173:8080/JudgeOnline/
    大连海事学院 http://acm.dlmu.edu.cn
    庆尚南道信息高中(韩国) http://oj.kninfo.hs.kr
    中国oier联盟 http://cnoier.com/oj/
    江西财经大学 http://jufeoj.sinaapp.com/
    维塔题库 http://www.wetta.in/
    金华职业技术学院 http://acm.jhc.cn/JudgeOnline/
    吉大附中 http://222.168.93.70/oj/
    滨海中学 http://oj.i7study.com:88/
    上海交大cs358 http://wirelesslab.sjtu.edu.cn:8080/JudgeOnline/
    中国海洋大学 http://oooj.sinaapp.com/
    绥化学院 http://shxyacm.sinaapp.com/
    重庆邮电大学 http://oj.bbs.cqupt.edu.cn/
    东北大学秦皇岛分校 http://ncc.neuq.edu.cn/oj/
    河南师大附中 http://wangmingxuan.cn/
    Rutgers新泽西州立大学(US) cs111 http://edsvc.cs.rutgers.edu/JudgeOnline/
    香港理工大学 http://oj.zloop.net
    长沙理工大学 http://acmore.net/ 
    江西理工大学 http://oj.jxust.edu.cn/

内网用户：

    重庆大学 http://172.31.2.24/JudgeOnline/
    湖南吉首大学 http://10.0.0.254:8080/JudgeOnline/ （内网）
    哈尔滨商业大学(原黑龙江商学院) http:/210.46.118.109/JudgeOnline?
    泉州市师范学院 http://219.229.75.223/JudgeOnline/
    美国普渡大学
    宁波镇海中学 升级自POJ免费版
    大连东软信息学院
    深圳市第二实验学校
    辽宁工程技术大学
    北航珠海分校
    义乌工商职业技术学院
    铜陵市一中
    中国石油大学
    杭州师范学院
    齐鲁软件学院
    嘉兴秀洲新区实验学校
    深圳华为3G http://3goj.huawei.com/JudgeOnline/
    内蒙古大学 http://202.207.12.224/JudgeOnline/
    华中师范大学 http://202.114.46.55/JudgeOnline/
    沈阳工业大学
    长冈技术科学大学(日本) ksl-t98.nagaokaut.ac.jp
    浙江省水利水电专科学校
    浙江省慈溪中学
    西南交通大学峨眉校区 http://7.10.0.17/JudgeOnline/
    浙江大学宁波理工学院 http://10.80.102.219
    利物浦大学 http://csc.liv.ac.uk/JudgeOnline/ 

首批LiveCD试用：

    浙江纺织服装学院
    湖州职业技术学院
    浙江理工大学
    嘉兴职业技术学院
    浙江工业大学
    宁波工程学院
    宁波职业技术学院
    香港中文大学 

LiveCD iso 下载 https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md

需要邮寄LiveCD光盘可以访问 淘宝链接，高校教师购买可享受8折优惠。 


--------请人类浏览者忽略以下信息--------

引诱爬虫实验，请勿点击。http://book.taoshell.com/
