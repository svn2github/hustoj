hustoj
======
微信公众号:hustoj
<img src="http://hustoj.com/wx.jpg" height="180">
HUSTOJ is an GPL FreeSoftware?.

HUSTOJ 是采用GPL的自由软件。

注意：基于本项目源码从事科研、论文、系统开发，"最好"在文中或系统中表明来自于本项目的内容和创意，否则所有贡献者可能会鄙视你和你的项目。使用本项目源码和freeproblemset题库请尊重程序员职业和劳动。

论文请引用参考文献[基于开放式云平台的开源在线评测系统设计与实现](http://kns.cnki.net/KCMS/detail/detail.aspx?dbcode=CJFQ&dbname=CJFD2012&filename=JSJA2012S3088&uid=WEEvREcwSlJHSldRa1FhdXNXYXJwcFhRL1Z1Q2lKUDFMNGd0TnJVVlh4bz0=$9A4hF_YAuvQ5obgVAqNKPCYcEjKensW4ggI8Fm4gTkoUKaID8j8gFw!!&v=MjgwNTExVDNxVHJXTTFGckNVUkwyZlllWm1GaURsV3IvQUx6N0JiN0c0SDlPdnJJOU5iSVI4ZVgxTHV4WVM3RGg=)

PS: GPL保证你可以合法忽略以上注意事项但不能保证你不受鄙视，呵呵。

Ubuntu14.04（推荐）快速安装指南：  

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu14.04.sh
    sudo bash install-ubuntu14.04.sh
  
ubuntu16.04（不推荐），可以使用下面脚本

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu16+.sh
    sudo bash install-ubuntu16+.sh


https://www.youtube.com/watch?v=nlhmfZqyHnA 


centos7 （不推荐），可以使用下面脚本

    wget https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-centos7.sh
    sudo bash install-centos7.sh
    
https://www.youtube.com/watch?v=hRap7ettUWc

<b>安装完成，用admin作为用户名注册一个用户，自动成为管理员。</b>

安装后几个重要配置文件的位置

    /home/judge/etc/judge.conf
    /home/judge/src/web/include/db_info.inc.php
    /etc/php5/fpm/php.ini 或 /etc/php7.0/fpm/php.ini
    /etc/nginx/sites-enabled/default

REDHAT / CENTOS 用户请浏览 

https://github.com/zhblue/hustoj/blob/master/wiki/CentOSx86_64.md

https://github.com/zhblue/hustoj/blob/master/wiki/CentOS.md


docker安装
```	
mkdir -p /data/docker/docker-wxy/data \
        /data/docker/docker-wxy/mysql:\
         /data/docker/docker-wxy/upload\
        /data/docker/docker-wxy/config
chmod 777 /data/docker/docker-wxy/data \
        /data/docker/docker-wxy/mysql:\
         /data/docker/docker-wxy/upload\
        /data/docker/docker-wxy/config

docker stop hustoj
docker rm hustoj
docker pull shiningrise/hustoj
docker run -d -it \
    -v /data/docker/docker-wxy/data:/home/judge/data \
    -v /data/docker/docker-wxy/mysql:/var/lib/mysql \
    -v /data/docker/docker-wxy/upload:/home/judge/src/web/upload \
    -v /data/docker/docker-wxy/config:/home/judge/src/web/config \
    --name hustoj -p 80:80 shiningrise/hustoj:latest

	附加说明：
		/home/data/data   # 测试数据目录
		/home/data/mysql  # mysql数据库目录
		/home/data/upload #文件上传目录
		/home/data/config #配置文件目录

docker测试安装
	docker run -d -it --name hustoj -p 80:80 shiningrise/hustoj:latest
```	


[更多安装方法](https://github.com/zhblue/hustoj/blob/master/trunk/install/README)

有问题请先查阅
<b>[FAQ](https://github.com/zhblue/hustoj/blob/master/wiki/FAQ.md)</b> 和
<b>[Wiki](https://github.com/zhblue/hustoj/tree/master/wiki)</b> 或使用搜索引擎。  

使用上需要帮助，请加用户交流QQ群23361372，仅支持开通支付功能的手机QQ加群，不接受其他方式加群。
群共享有题库 安装盘 文档 ，群内可以讨论 答疑 。
新加群，请改群名片，5分钟后可以发言 。
请尊重开源软件开发者的辛苦劳动，出言不逊者将被踢出，群费不退。


Linux不熟悉的用户推荐使用:
HUSTOJ_LiveCD(关注微信公众号onlinejudge获得下载链接)
HUSTOJ_Windows（仅支持XP,QQ群23361372共享文件）进行安装。

使用说明见iso中README,也可以参考[LiveCD简介](https://github.com/zhblue/hustoj/tree/master/wiki/HUSTOJ_LiveCD.md)  

Linux新手请看[鸟哥的私房菜](http://cn.linux.vbird.org/linux_basic/linux_basic.php)

建好系统需要题目，请访问[TK题库](http://tk.hustoj.com/)


[前台演示](http://hustoj.com/oj/)

后台功能：
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/menu.png" >
----------------------
硬件需求：
<img src="https://raw.githubusercontent.com/zhblue/hustoj/master/wiki/hardware.png" >


