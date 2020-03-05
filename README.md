hustoj -- 流行的OJ系统，跨平台、易安装、有题库。
======

版权说明
--
HUSTOJ is an [GPL](https://github.com/zhblue/hustoj/blob/master/trunk/web/gpl-2.0.txt) Free Software.

HUSTOJ 是采用GPL的自由软件。(仅限原创部分代码，其中使用了其他开源项目的组件，请遵循原组件的协议。)

注意：基于本项目源码从事科研、论文、系统开发，请在文中或系统中表明来自于本项目的内容和创意。

论文请引用参考文献[基于开放式云平台的开源在线评测系统设计与实现](http://kns.cnki.net/KCMS/detail/detail.aspx?dbcode=CJFQ&dbname=CJFD2012&filename=JSJA2012S3088&uid=WEEvREcwSlJHSldRa1FhdXNXYXJwcFhRL1Z1Q2lKUDFMNGd0TnJVVlh4bz0=$9A4hF_YAuvQ5obgVAqNKPCYcEjKensW4ggI8Fm4gTkoUKaID8j8gFw!!&v=MjgwNTExVDNxVHJXTTFGckNVUkwyZlllWm1GaURsV3IvQUx6N0JiN0c0SDlPdnJJOU5iSVI4ZVgxTHV4WVM3RGg=)

如果打算进行二次开发，[Wiki](https://github.com/zhblue/hustoj/tree/master/wiki)和这份[文档](https://github.com/zhblue/hustoj/blob/master/wiki/hustoj%E6%96%87%E6%A1%A3%E5%A4%A7%E5%85%A8.pdf)可能有帮助。

PS: GPL保证你可以合法忽略以上注意事项但不能保证你不受鄙视，呵呵。

常见问题自动应答微信公众号:hustoj          <img src="http://hustoj.com/wx.jpg" height="180">

关注后回复： 新装系统、升级、目录等关键词，系统会自动回复相关帮助。

有问题请先查阅
<b>[FAQ常见问答](https://github.com/zhblue/hustoj/blob/master/wiki/FAQ.md)</b> 和
<b>[Wiki使用技巧](https://github.com/zhblue/hustoj/tree/master/wiki)</b> 或使用搜索引擎。 


如果这个项目对你有用，请：

* 挥动鼠标，右上角给个Star!
* 保留网站页脚的二维码
* 访问[tk题库](http://tk.hustoj.com)，充值下载题目
* 向同学同事推荐这个项目
* 每天扫一扫本页底部的支付宝红包
* 在您的论文参考文献中写出本项目的网址

[热烈祝贺CCPC2019顺利举办！](http://rank.ccpc.io/)

Star us, please!


目录
--

[更新日志](#%E6%9B%B4%E6%96%B0%E6%97%A5%E5%BF%97)

[安装说明](#%E5%AE%89%E8%A3%85%E8%AF%B4%E6%98%8E)

[注意事项](#%E6%B3%A8%E6%84%8F%E4%BA%8B%E9%A1%B9)

[校园网安装](#%E6%A0%A1%E5%9B%AD%E7%BD%91%E5%AE%89%E8%A3%85)

[基于Ubuntu18.04安装](#%E5%9F%BA%E4%BA%8Eubuntu1804%E5%AE%89%E8%A3%85)

[基于Deepin深度15安装](#%E5%9F%BA%E4%BA%8Edeepin15%E5%AE%89%E8%A3%85)

[基于Centos安装](#%E5%9F%BA%E4%BA%8Ecentos%E5%AE%89%E8%A3%85)

[基于Docker安装](#%E5%9F%BA%E4%BA%8Edocker%E5%AE%89%E8%A3%85)

[基于其他发行版安装](#%E5%9F%BA%E4%BA%8E%E5%85%B6%E4%BB%96%E5%8F%91%E8%A1%8C%E7%89%88%E5%AE%89%E8%A3%85)

[LiveCD下载安装](#livecd%E4%B8%8B%E8%BD%BD%E5%AE%89%E8%A3%85)

[装后须知](#%E8%A3%85%E5%90%8E%E9%A1%BB%E7%9F%A5)

[备份](#%E5%A4%87%E4%BB%BD)

[迁移](#迁移)

[升级](#升级)

[支持捐助、加入社区](#%E6%94%AF%E6%8C%81%E6%8D%90%E5%8A%A9%E5%8A%A0%E5%85%A5%E7%A4%BE%E5%8C%BA)

[二次开发](https://github.com/zhblue/hustoj/blob/master/wiki/SecondaryDevelopment.md)

[系统演示](#%E7%B3%BB%E7%BB%9F%E6%BC%94%E7%A4%BA)

[硬件需求](#%E7%A1%AC%E4%BB%B6%E9%9C%80%E6%B1%82)

[免费题库](#%E5%85%8D%E8%B4%B9%E9%A2%98%E5%BA%93)

[求助 报错](https://github.com/zhblue/hustoj/issues/new/choose)

如果您喜欢在线聊天，希望问题获得及时反馈，不介意付费获得服务，请加[官方群23361372](https://shang.qq.com/wpa/qunwpa?idkey=d52c3b12ddaffb43420d308d39118fafe5313e271769277a5ac49a6fae63cf7a)

更新日志
------
2020-02-10 更新：新的模板bshark基本可用，如需启用新模板，只需修改/home/judge/src/web/include/db_info.inc.php，设置$OJ_TEMPLATE="bshark";

2020-01-31 更新：@melongist 增加了很多页面美化。

2020-01-27 更新：题目限时增强为浮点型，3位小数精度，即标称毫秒(ms)。

2020-01-26 更新：允许为每个Web添加多个UDP通知对象，每个判题服务器允许使用不同的UDP端口监听消息。阿里云+腾讯云测试通过。

2020-01-23 更新：修订了[Moodle集成代码](https://github.com/zhblue/hustoj/blob/master/wiki/MoodleIntegration.md)，实现HUSTOJ给moodle系统作业自动判分。

2020-01-20 更新：删除noip模式比赛的多余提交记录，允许自定义“noip”关键词，增加privilege表user_id索引。

2019-12-19 更新：增加了judge.conf中的注释，提供了备案号变量$OJ_BEIAN，对系统判题时间分辨率进行了更新优化，提高灵活度。

2019-11-23 喜讯：hustoj在首届深度软件开发大赛中获得三等奖。

2019-11-21 补丁：修复比赛中Edit按钮后可以选择出题人禁用的语言提交【感谢湘潭大学谢老师的报告】。

2019-11-20 更新：在运行结果对比输出（OJ_SHOW_DIFF）中提示每个数据点的结果(AC/WA/TLE...)。

2019-11-16 优化：[muzea](https://github.com/muzea) 开发了从github到[gitee](https://gitee.com/zhblue/hustoj)的同步机制，并部署了CI。

2019-11-13 更新：在运行时错误(RuntimeError)中显示数据点文件名(infile)

2019-10-30 更新：提供$OJ_OI_MODE开关。

2019-10-29 更新：加强了OI模式下的限制，控制Web行为。

2019-10-3 更新：修订测试deepin15.11安装脚本，补丁：注册页面验证csrf

2019-9-23 补丁：修复昵称比赛中不更新问题，以及提醒官方群用户及时更新处理504超时问题。

2019-9-21 补丁：修复部分安装脚本不能执行第二次的问题

2019-8-6 更新：支持用UDP数据包触发判题轮询，实现Web本地judge秒判。

2019-7-26 更新：支持华为鲲鹏服务器，aarch64，感谢深度科技公司和华为云提供鲲鹏服务器。

2019-7-6 NOIP：对于标题带有NOIP字样的比赛，比赛结束后才能看到结果。

2019-7-4 mark：设置$OJ_MARK="mark"显示得分，$OJ_MARK="percent"显示错误率(WA)或通过率（AC），设置$OJ_MARK=""只显示最终结果。

2019-6-24 文档：对项目首页进行分块标注，调整顺序和内容，增加目录。

2019-6-12 更新：添加Fortran语言、Matlab(Octave)，修订：比赛结束后编辑时丢失提交统计数据、修复部分RE。

2019-5-18 修订：16.04以上版本FB显示异常。 [基于OpenJudger的Windows集成便携版](https://github.com/Azure99/WinHustOJ/releases) [浙传网盘](https://pan.cuz.edu.cn:8443/share/b02149ee631b2776e93590b461)

2019-5-17 修订：改善ajax，减少并发量，降低web压力，提高judge轮询效率。

2019-5-15 修订：修复了部分TLE误判为RE的情况，主要是在Ubuntu18/19 Deepin15.9/15.10 以上的版本，估计与gcc/g++有关。

2019-5-7   更新：muzea 提供了Debian安装包打包(*.deb)，https://github.com/zhblue/hustoj/releases

2019-4-13  更新：支持SQL判题，基于sqlite3，支持龙芯3A3000（致谢江苏航天龙梦信息技术有限公司提供龙芯主机！）。

2019-3-14  更新:主线支持  树莓派(arm)  <b>龙芯(loongson-2f)</b>  i386 x86_64 

安装说明
------

注意事项
--
根据你选择的发行版不同，从下面三个脚本里选一个来用。

<b>不要相信百度来的长篇大论的所谓教程，那些都是好几年前的老皇历了，会导致不判题，不显示，不好升级等等问题。</b>
	
尤其<b>别装apache</b>，如果已经安装，请先停用或卸载，以免80端口冲突。

<b>不要</b>使用LNMP/LAMP/Cpanel/其他面板程序提供的Mysql Nginx Apache PHP 环境，安装脚本已经包含所有必须环境的安装。

腾讯云用户请[换软件源](https://yq.aliyun.com/articles/704603)，增加multiverse。

阿里云用户请百度“阿里云 80端口”

校园网安装
--
近期github的svn访问缓慢，可以到release中下载tar.gz版本，然后用install目录下的*-bytgz.sh脚本安装。
但是注意这样安装的实例，将来升级时只能手工升级。
例如18.04下载好Releases中的19.06.04.tar.gz，然后准备好install-ubuntu18-bytgz.sh

```
sudo bash install-ubuntu18-bytgz.sh 19.06.04.tar.gz
```
基于Ubuntu18.04 通过gitee安装 / 腾讯云用户请[换软件源](https://yq.aliyun.com/articles/704603)
--
```
wget https://gitee.com/zhblue/hustoj/raw/master/trunk/install/install-ubuntu18-gitee.sh
sudo bash install-ubuntu18-gitee.sh
```

基于Ubuntu18.04安装  / 腾讯云用户请[换软件源](https://yq.aliyun.com/articles/704603)
--

    wget https://github.com/zhblue/hustoj/raw/master/trunk/install/install-ubuntu18.04.sh
    sudo bash install-ubuntu18.04.sh
    
    
基于Deepin15+安装
--

国内桌面用户Deepin15.9+(内置QQ微信WPS方便出题人本地测试，最新15.11测试通过)

    wget https://github.com/zhblue/hustoj/raw/master/trunk/install/install-deepin15.9.sh
    sudo bash install-deepin15.9.sh
    
    
基于Centos安装
--
假如你不得已非要用centos7 （有的语言可能不支持，但是某些机架式服务器的Raid卡Ubuntu不认只能装CentOS），可以用下面脚本快速安装OJ：  

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-centos7.sh
    sudo bash install-centos7.sh
    
REDHAT / CENTOS 用户请浏览 

https://github.com/zhblue/hustoj/blob/master/wiki/CentOSx86_64.md

https://github.com/zhblue/hustoj/blob/master/wiki/CentOS.md


基于Docker安装
--
docker安装，可用于快速体验HUSTOJ的全部功能，<b>可能存在未知的魔法问题，请慎重考虑用于生产环境！！！</b>
使用构建好的docker镜像（GitLab CI/CD系统自动构建）

```shell
docker run -d           \
    --name hustoj       \
    -p 8080:80          \
    -v ~/volume:/volume \
    registry.gitlab.com/mgdream/hustoj
```

由于Web端/数据库/判题机全部被打包在同一个镜像，无法扩展，不推荐使用此镜像做分布式判题，另外请不要在Docker中使用SHM文件系统，会由于内存空间不足无法挂载沙箱环境而导致莫名其妙的运行错误

部署后使用浏览器访问[http://localhost:8080](http://localhost:8080)

基于其他发行版安装
--
其他的发行版，如树莓派的raspbian8/9,ubuntu14.04,deepin的安装脚本在install目录可以找到，但是不完善，安装后需要部分手工修复调整。

https://www.youtube.com/watch?v=hRap7ettUWc

树莓派用户请用rpi分支源码（实验性质）手工搭建web，并编译安装core目录下的judged和judge_client。

[更多安装方法](https://github.com/zhblue/hustoj/blob/master/trunk/install/README)


LiveCD下载安装
--
Linux不熟悉的用户推荐使用:

HUSTOJ_LiveCD(发送"livecd"到微信公众号onlinejudge，获得百度云下载链接)

HUSTOJ_Windows（仅支持XP,QQ群23361372共享文件）进行安装。

使用说明见iso中README,也可以参考[LiveCD简介](https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md)  

Linux新手请看[鸟哥的私房菜](http://cn.linux.vbird.org/linux_basic/linux_basic.php)

建好系统需要题目，请访问[TK题库](http://tk.hustoj.com/) 和 [freeeproblemset项目](https://github.com/zhblue/freeproblemset)


装后须知
--
常见问题自动应答微信公众号:hustoj
<img src="http://hustoj.com/wx.jpg" height="180">
关注后回复： 新装系统、升级、目录等关键词，系统会自动回复相关帮助。

有问题请先查阅
<b>[FAQ常见问答](https://github.com/zhblue/hustoj/blob/master/wiki/FAQ.md)</b> 和
<b>[Wiki使用技巧](https://github.com/zhblue/hustoj/tree/master/wiki)</b> 或使用搜索引擎。 

<b>安装完成，用admin作为用户名注册一个用户，自动成为管理员。</b>

大部分功能和选项的开关和参数调整都在配置文件中，安装后几个重要配置文件的位置如下：

    /home/judge/etc/judge.conf                                                      判题judged/judge_client
    /home/judge/src/web/include/db_info.inc.php                                     Web
    /etc/php5/fpm/php.ini 或 /etc/php7.0/fpm/php.ini 或 /etc/php.ini (in Centos7)    php
    /etc/nginx/sites-enabled/default 或 /etc/nginx/nginx.conf (in Centos7)          nginx
    
如果用户量比较大，报50x错误,可能需要修改/etc/nginx/nginx.conf中的设置：
```
	worker_processes 8;    #其中数字8可以取CPU核心数的整数倍。
	events {
		worker_connections 2048;
		multi_accept on;
	}
```
如果遇到比赛人数多，比赛排名xls文件无法下载，请修改/etc/nginx/sites-enabled/default,在fastcgi_pass一行的后面增加
```
 	fastcgi_buffer_size 128k;
        fastcgi_buffers 32 32k;
```
保存后，重启nginx

备份
--
脚本安装的用户，可以使用install目录中的bak.sh进行备份。
```
sudo bash /home/judge/src/install/bak.sh
```
备份后的数据在/var/backups/

百度学习crontab的用法后，可以使用
```
sudo crontab -e
```
定制自动备份计划，部分安装脚本中包含了自动备份，但可能需要运行上面的语句一次来激活。

迁移
--
如果你需要进行跨系统迁移（如从Ubuntu迁移到CentOS），可以尝试使用下面的脚本进行备份
```shell
sudo bash /home/judge/src/install/backup+.sh
```
备份后的归档在`/home/judge/backup`，命名格式为`%Y-%m-%d-%H-%M-%S`

将你需要迁移的归档复制到目标系统的`/home/judge/backup`目录下，执行下面的脚本进行恢复
```shell
sudo bash /home/judge/src/install/restore+.sh
```
脚本的第一个参数为恢复的目标归档，如果没有参数则默认为按名字排序后字典序最大的归档

升级
--
脚本安装的用户，可以使用install目录中的update-hustoj进行升级。
```
sudo bash /home/judge/src/install/update-hustoj
```
升级脚本执行后，可能需要登陆web端管理后台，执行一次更新数据库。

修复
--
自己不小心改坏了web代码，可以使用install目录中的fixing.sh进行系统修复。


支持捐助、加入社区
--

使用上需要帮助，请加用户交流QQ群23361372，验证问题答案：开源软件。
或加[TG](https://t.me/hustoj2019)群

群共享有题库 安装盘 文档 ，群内可以讨论 答疑 。
新加群，请改群名片，5分钟后可以发言 。
请尊重开源软件开发者的辛苦劳动，出言不逊者将被踢出，群费不退。

您可以用这几种方式支援本项目：

1、付费50加入官方群23361372

2、领取并使用支付宝红包

<img src="http://tk.hustoj.com/upload/image/20180621/20180621190059_62537.png" width="140px">

3、在[TK题库](http://tk.hustoj.com)充值下载题目

4、右上角点击Star，给本项目加星

5、保留您安装使用的系统中页脚的公众号和红包二维码

6、在您的论文中引用本项目的网址

7、向其他老师同学推荐本项目

系统演示
--
[前台演示](http://hustoj.com/oj/)
[龙芯部署](http://loongson.hustoj.com/)

后台功能
--
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/menu.png" >

硬件需求
--
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/hardware.png" >

更严谨的请求数QPS测试,请参考muzea的[hustoj web 跑分小工具](https://github.com/muzea/hustoj-benchmark)

免费题库
--
访问项目[FPS](https://github.com/zhblue/freeproblemset/tree/master/fps-examples)下载免费例程。

访问[TK题库免费专区](http://tk.hustoj.com/problemset.php?search=free)

FQ访问[谷歌代码存档版](http://code.google.com/p/freeproblemset)，下载老版本FPS共享题库。
