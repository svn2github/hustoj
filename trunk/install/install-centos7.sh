#!/bin/bash
DBNAME="jol"
DBUSER="root"
DBPASS=`tr -cd '[:alnum:]' < /dev/urandom | fold -w30 | head -n1`
CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`
yum -y update
yum -y install nginx php-fpm php-mysql php-xml php-gd gcc-c++  mysql-devel php-mbstring glibc-static libstdc++-static flex java-1.8.0-openjdk java-1.8.0-openjdk-devel
yum -y install mariadb mariadb-devel mariadb-server
systemctl start mariadb.service 
/usr/sbin/useradd -m -u 1536 judge
cd /home/judge/
yum -y install subversion
svn co https://github.com/zhblue/hustoj/trunk/trunk/ src
cd src/install
mysql -h localhost -uroot < db.sql
echo "insert into jol.privilege values('admin','administrator','N');"|mysql -h localhost -uroot
mysqladmin -u root password $DBPASS
cd ../../

mkdir etc data log

cp src/install/java0.policy  /home/judge/etc
cp src/install/judge.conf  /home/judge/etc
chmod +x src/install/ans2out

if grep "OJ_SHM_RUN=0" etc/judge.conf ; then
	mkdir run0 run1 run2 run3
	chown apache run0 run1 run2 run3
fi

#sed -i "s/OJ_USER_NAME=root/OJ_USER_NAME=$USER/g" etc/judge.conf
sed -i "s/OJ_PASSWORD=root/OJ_PASSWORD=$DBPASS/g" etc/judge.conf
sed -i "s/OJ_COMPILE_CHROOT=1/OJ_COMPILE_CHROOT=0/g" etc/judge.conf
sed -i "s/OJ_RUNNING=1/OJ_RUNNING=$CPU/g" etc/judge.conf

chmod 700 etc/judge.conf

#sed -i "s/DB_USER=\"root\"/DB_USER=\"$USER\"/g" src/web/include/db_info.inc.php
sed -i "s/DB_PASS=\"root\"/DB_PASS=\"$DBPASS\"/g" src/web/include/db_info.inc.php

sed -i "s+//date_default_timezone_set("PRC");+date_default_timezone_set("PRC");+g" src/web/include/db_info.inc.php
sed -i "s+//pdo_query("SET time_zone ='+8:00'");+pdo_query("SET time_zone ='+8:00'");+g" src/web/include/db_info.inc.php

chmod 775 -R /home/judge/data && chgrp -R apache /home/judge/data
chmod 700 src/web/include/db_info.inc.php

chown apache src/web/include/db_info.inc.php
chown apache src/web/upload data run0 run1 run2 run3
cp /etc/nginx/nginx.conf /home/judge/src/install/nginx.origin
cp /home/judge/src/install/nginx.conf /etc/nginx/
systemctl restart nginx.service

sed -i "s/post_max_size = 8M/post_max_size = 80M/g" /etc/php.ini
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 80M/g" /etc/php.ini


systemctl restart php-fpm.service
chmod 755 /home/judge
chown apache -R /home/judge/src/web/

mkdir /var/lib/php/session
chown apache /var/lib/php/session

cd /home/judge/src/core
chmod +x make.sh
./make.sh

if grep "/usr/bin/judged" /etc/rc.local ; then
	echo "auto start judged added!"
else
	sed -i "s/exit 0//g" /etc/rc.local
	echo "/usr/bin/judged" >> /etc/rc.local
	echo "exit 0" >> /etc/rc.local
	
fi
/usr/bin/judged

# mono install for c# 
yum -y install yum-utils
rpm --import "http://keyserver.Ubuntu.com/pks/lookup?op=get&search=0x3FA7E0328081BFF6A14DA29AA6A19B38D3D831EF"
yum-config-manager --add-repo http://download.mono-project.com/repo/centos/ 
yum -y update
yum -y install mono
ln -s /usr/bin/mcs /usr/bin/gmcs

#free pascal
wget https://downloads.sourceforge.net/project/freepascal/Linux/3.0.4/fpc-3.0.4.x86_64-linux.tar
tar xf fpc-3.0.4.x86_64-linux.tar
cd fpc-3.0.4.x86_64-linux
echo -e "\n\n\n\n\n\n\n\n\n\n"|sh install.sh


reset
echo "Remember your database account for HUST Online Judge:"
echo "username:root"
echo "password:$DBPASS"
