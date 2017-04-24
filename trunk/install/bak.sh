#!/bin/bash
DATE=`date +%Y%m%d`
OLD=`date -d"1 day ago" +"%Y%m%d"`
OLD3=`date -d"3 day ago" +"%Y%m%d"`
USER=`cat /etc/mysql/debian.cnf |grep user|head -1|awk  '{print $3}'`
PASSWORD=`cat /etc/mysql/debian.cnf |grep password|head -1|awk  '{print $3}'`

mysqldump -R --all-databases -u$USER -p$PASSWORD | bzip2 >/var/backups/db_${DATE}.bz2
if tar cjf /var/backups/hustoj_${DATE}.tar.bz2 /home/judge/data /home/judge/src /home/judge/etc /var/backups/db_${DATE}.bz2; then
	rm /var/backups/hustoj_${OLD3}.tar.bz2
	rm /var/backups/db_${OLD}.bz2
fi
