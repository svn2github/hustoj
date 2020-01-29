#summary CentOS用户须知 CentOS user need to know
#labels Featured,Phase-Deploy,Phase-Support

尽管我们强烈推荐使用Debian/Ubuntu，但是由于驱动或资源的原因，有的用户不得不使用CentOS/RE/Federa。

Through Debian/Ubuntu is highly recommended, but in case of server hardware drivers or something else, people like to install HUSTOJ on CentOS/RedHat/Federa system.

这里是已知的一些问题。
Here is something for those users:

 * yum install php httpd php-mysql mysql-server php-xml php-gd gcc-c++ php-mbstring glibc

 * 默认web目录在/var/www/html，需要调整install.sh中的设置

 * SELinux会影响PHP的运行，可能需要关闭(/etc/selinux/config and setenforce 0)才能web编辑测试数据。
   或者执行 chcon -R -t httpd_sys_content_t /home

 * PHP.ini的位置在/etc/php.ini

 * php.ini中short_open_tag必须设为On,但是似乎默认为Off

 * php.ini中register_globals必须设为Off,但是似乎默认为On

 * 编译时mysql库的位置在/usr/lib/mysql
   因此需要手工修改judged和judge_client中两个makefile 
   将  -L/usr/local/mysql/lib/mysql 改为  -L/usr/lib/mysql
       -I/usr/local/mysql/include/mysql 改为 -I/usr/include/mysql
 * install what you need before starting by :
   yum install php httpd php-mysql mysql-server php-xml php-gd gcc-c++
 * the default web site root directory is different from debian/ubuntu
   /var/www/html  you gonna need to adjust it in install.sh before running "sudo ./install.sh"
 * SELinux settings will stop php when it trying to make file I/O, so if you don't know how to make SELinux working with HUSTOJ, just disable it for a moment(/etc/selinux/config and setenforce 0), and find the right way later.
this line should works
```
chcon -R -t httpd_sys_content_t /home
```
 * PHP.ini is located at /etc/php.ini
 * You need to change php.ini
```
short_open_tag=On
register_globals=Off
open_basedir=/var/www/html:/home/judge/src/web:/tmp:/home/judge/data
```
 *  change makefiles in core/judged and core/judge_client
   change -L/usr/local/mysql/lib/mysql to -L/usr/lib/mysql
        -I/usr/local/mysql/include/mysql to -I/usr/include/mysql

for English user ,email or issue is recommended
for Chinese user ,QQ-qun group IM is recomended.

================

刚刚在全新的CentOS 5.6中安装了OJ，主要遇到问题和解决方法如下：
 * 安装时候提示找不到www-data用户，修改web的用户为apache
 * 运行/etc/init.d/judged出错，提示/lib/init/vars.sh找不到，修改/etc/init.d/judged,删除原有内容，修改内容为:
```
/usr/bin/judged
```
 * 打开页面空白，这是由于CentOS默认带的php版本为5.1，不支持mysql_set_charset函数，这个函数需要5.2.3的支持，打开include/db_info.inc.php，注释掉第37行:
```
if(!$OJ_SAE)mysql_set_charset("utf8");
```
 * 打开题目列表页面不完全，yum install php-mbstring。

关于Java，如果Java提示编译失败，可以尝试：
1、卸载Java，安装官方jdk
2、测试（应该继续失败）
3、卸载官方jdk，安装java-1.6.0-openjdk-devel
4、测试（貌似就没有问题了，原因不明）
PS:在CentOS 6下测试通过。
