#!/bin/bash
DATE=`date +%Y%m%d`
OLD=`date -d"1 day ago" +"%Y%m%d"`
OLD3=`date -d"3 day ago" +"%Y%m%d"`
config="/home/judge/etc/judge.conf"
SERVER=`cat $config|grep 'OJ_HOST_NAME' |awk -F= '{print $2}'`
USER=`cat $config|grep 'OJ_USER_NAME' |awk -F= '{print $2}'`
PASSWORD=`cat $config|grep 'OJ_PASSWORD' |awk -F= '{print $2}'`
DATABASE=`cat $config|grep 'OJ_DB_NAME' |awk -F= '{print $2}'`

mysqldump -h $SERVER  -R $DATABASE -u$USER -p$PASSWORD | bzip2 >/var/backups/db_${DATE}.sql.bz2
if tar cjf /var/backups/hustoj_${DATE}.tar.bz2 /home/judge/data /home/judge/src /home/judge/etc /var/backups/db_${DATE}.sql.bz2 --exclude=/home/judge/src/install/*.bz2 ; then
	rm /var/backups/hustoj_${OLD3}.tar.bz2
	rm /var/backups/db_${OLD}.sql.bz2
fi
