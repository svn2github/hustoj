#!/bin/bash
config="/home/judge/etc/judge.conf"
VIRTUAL="/var/www/virtual/"
USER=`cat $config|grep 'OJ_USER_NAME' |awk -F= '{print $2}'`
PASSWORD=`cat $config|grep 'OJ_PASSWORD' |awk -F= '{print $2}'`
DBNAME=`cat $config|grep 'OJ_DB_NAME' |awk -F= '{print $2}'`
echo "mysql -u${USER} -p${PASSWORD} ${DBNAME} "
mysql -u${USER} -p${PASSWORD} ${DBNAME}
