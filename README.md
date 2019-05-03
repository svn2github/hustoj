hustoj -- 请一定认真看完本页再动手安装，以免无谓的折腾！
======

2019-4-13  更新：支持SQL判题，基于sqlite3，支持龙芯3A3000（致谢江苏航天龙梦信息技术有限公司提供龙芯主机！）。

2019-3-14  更新:主线支持  树莓派(arm)  <b>龙芯(loongson-2f)</b>  i386 x86_64 

根据你选择的发行版不同，从下面三个脚本里选一个来用。

<b>不要相信百度来的长篇大论的所谓教程，那些都是好几年前的老皇历了，会导致不判题，不显示，不好升级等等问题。</b>
	
尤其<b>别装apache</b>，如果已经安装，请先停用或卸载，以免80端口冲突。

近期github的svn访问缓慢，可以到release中下载tar.gz版本，然后用install目录下的*-bytgz.sh脚本安装。
但是注意这样安装的实例，将来升级时只能手工升级。

首先安装ubuntu16.04（推荐使用,php7速度杠杠的），然后用下面脚本快速安装OJ：  

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu16+.sh
    sudo bash install-ubuntu16+.sh

https://www.youtube.com/watch?v=nlhmfZqyHnA 

高级用户ubuntu18.04(至少1年以上debian系Linux使用经验，欢迎帮忙踩坑测试，有问题会尽快修复)

    wget https://github.com/zhblue/hustoj/raw/master/trunk/install/install-ubuntu18.04.sh
    sudo bash install-ubuntu18.04.sh

假如你不得已非要用centos7 （有的语言可能不支持，但是某些机架式服务器的Raid卡Ubuntu不认只能装CentOS），可以用下面脚本快速安装OJ：  

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-centos7.sh
    sudo bash install-centos7.sh

其他的发行版，如树莓派的raspbian8/9,ubuntu14.04,deepin的安装脚本在install目录可以找到，但是不完善，安装后需要部分手工修复调整。

https://www.youtube.com/watch?v=hRap7ettUWc

阿里云用户请百度“阿里云 80端口”

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


REDHAT / CENTOS 用户请浏览 

https://github.com/zhblue/hustoj/blob/master/wiki/CentOSx86_64.md

https://github.com/zhblue/hustoj/blob/master/wiki/CentOS.md


docker安装，<b>仅供docker熟练用户参考使用，不适合用于生产环境！切记！切记！</b>
```	
docker run -d -it \
    -v /data/docker/docker-wxy/data:/data \
    --privileged \
    --name hustoj \
    -p 80:80 shiningrise/hustoj:latest

docker测试安装
	docker run -d -it --name hustoj -p 80:80 --privileged shiningrise/hustoj:latest
仅安装C++版本
	docker run -d -it --name hustoj -p 80:80 --privileged shiningrise/hustoj:cpp
```	

树莓派用户请用rpi分支源码（实验性质）手工搭建web，并编译安装core目录下的judged和judge_client。

[更多安装方法](https://github.com/zhblue/hustoj/blob/master/trunk/install/README)

有问题请先查阅
<b>[FAQ](https://github.com/zhblue/hustoj/blob/master/wiki/FAQ.md)</b> 和
<b>[Wiki](https://github.com/zhblue/hustoj/tree/master/wiki)</b> 或使用搜索引擎。  

使用上需要帮助，请加用户交流QQ群23361372，仅支持开通支付功能的手机QQ加群，不接受其他方式加群。
群共享有题库 安装盘 文档 ，群内可以讨论 答疑 。
新加群，请改群名片，5分钟后可以发言 。
请尊重开源软件开发者的辛苦劳动，出言不逊者将被踢出，群费不退。


Linux不熟悉的用户推荐使用:
HUSTOJ_LiveCD(关注微信公众号onlinejudge获得百度云下载链接)
http://adc.zjicm.edu.cn/iso/hustoj20190128.iso


HUSTOJ_Windows（仅支持XP,QQ群23361372共享文件）进行安装。

使用说明见iso中README,也可以参考[LiveCD简介](https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md)  

Linux新手请看[鸟哥的私房菜](http://cn.linux.vbird.org/linux_basic/linux_basic.php)

建好系统需要题目，请访问[TK题库](http://tk.hustoj.com/) 和 [freeeproblemset项目](https://github.com/zhblue/freeproblemset)


[前台演示](http://hustoj.com/oj/)

后台功能：
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/menu.png" >
----------------------
硬件需求：
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/hardware.png" >

常见问题自动应答微信公众号:hustoj
<img src="http://hustoj.com/wx.jpg" height="180">

关注后回复： 新装系统、升级、目录等关键词，系统会自动回复相关帮助。


HUSTOJ is an GPL FreeSoftware?.

HUSTOJ 是采用GPL的自由软件。

注意：基于本项目源码从事科研、论文、系统开发，"最好"在文中或系统中表明来自于本项目的内容和创意，否则所有贡献者可能会鄙视你和你的项目。使用本项目源码和freeproblemset题库请尊重程序员职业和劳动。

论文请引用参考文献[基于开放式云平台的开源在线评测系统设计与实现](http://kns.cnki.net/KCMS/detail/detail.aspx?dbcode=CJFQ&dbname=CJFD2012&filename=JSJA2012S3088&uid=WEEvREcwSlJHSldRa1FhdXNXYXJwcFhRL1Z1Q2lKUDFMNGd0TnJVVlh4bz0=$9A4hF_YAuvQ5obgVAqNKPCYcEjKensW4ggI8Fm4gTkoUKaID8j8gFw!!&v=MjgwNTExVDNxVHJXTTFGckNVUkwyZlllWm1GaURsV3IvQUx6N0JiN0c0SDlPdnJJOU5iSVI4ZVgxTHV4WVM3RGg=)

如果打算进行二次开发，[Wiki](https://github.com/zhblue/hustoj/tree/master/wiki)和这份[文档](https://github.com/zhblue/hustoj/blob/master/wiki/hustoj%E6%96%87%E6%A1%A3%E5%A4%A7%E5%85%A8.pdf)可能有帮助。

PS: GPL保证你可以合法忽略以上注意事项但不能保证你不受鄙视，呵呵。

如果这个项目对你有用，请挥动鼠标，右上角给个Star!

Star us, please!

<img src="http://tk.hustoj.com/upload/image/20180621/20180621190059_62537.png" width="240px">




