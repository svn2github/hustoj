#!/bin/bash

USER=`cat /etc/mysql/debian.cnf |grep user|head -1|awk  '{print $3}'`
PASSWORD=`cat /etc/mysql/debian.cnf |grep password|head -1|awk  '{print $3}'`
CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`
pkill -9 judged
service php7.2-fpm stop
service mysql stop
service nginx stop
service memcache stop

echo "drop database jol;"|mysql -h localhost -u$USER -p$PASSWORD 

for PKG in  make flex g++ clang libmysqlclient-dev libmysql++-dev php-fpm nginx mysql-server php-mysql  php-common php-gd php-zip fp-compiler openjdk-11-jdk mono-devel php-mbstring php-xml
do
	apt-get purge -y $PKG
done
userdel -r judge
