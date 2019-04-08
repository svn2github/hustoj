#!/usr/bin/bash

# current timestamp
cdate=`date '+%Y-%m-%d-%H-%M-%S'`

mkdir /home/judge/backup
mkdir /home/judge/backup/${cdate}
mkdir /home/judge/backup/${cdate}/etc
mkdir /home/judge/backup/${cdate}/src

# Get database password
OJ_USERNAME=`cat /home/judge/etc/judge.conf | grep OJ_USER_NAME`
OJ_PASSWORD=`cat /home/judge/etc/judge.conf | grep OJ_PASSWORD`
DB_USERNAME=`echo ${OJ_USERNAME:13}`
DB_PASSWORD=`echo ${OJ_PASSWORD:12}`

echo "dump mysql/mariadb database"
mysqldump -u${DB_USERNAME} -p${DB_PASSWORD} -B jol > /home/judge/backup/${cdate}/jol.sql

echo "backup data directory"
cp -r /home/judge/data /home/judge/backup/${cdate}/data

echo "backup config files"
cp /home/judge/etc/java0.policy /home/judge/backup/${cdate}/etc/java0.policy
cp /home/judge/etc/judge.conf   /home/judge/backup/${cdate}/etc/judge.conf

echo "backup web files"
cp -r /home/judge/src/web /home/judge/backup/${cdate}/src/web

echo "Create backup archive"
tar -zcvf /home/judge/backup/${cdate}.tar.gz -C /home/judge/backup/${cdate} jol.sql data etc src

echo "clean backup temp files"
rm -rf /home/judge/backup/${cdate}

echo "数据千万条，备份第一条。"
echo "备份不及时，运维两行泪。"
echo "Data is tens of thousands,"
echo "backing up the first one."
echo "The backup is not timely,"
echo "and the operation and maintenance of the two lines of tears."
