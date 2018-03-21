#!/bin/bash
URL=$1
USER=$2
PASSWORD=$3
TARGET=$4
apt-get update
apt-get install -y subversion
/usr/sbin/useradd -m -u 1536 judge
cd $TARGET/
svn co https://github.com/zhblue/hustoj/trunk/trunk/ src
apt-get install -y make flex g++ clang libmysqlclient-dev libmysql++-dev fp-compiler openjdk-7-jdk
CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`
mkdir etc data log
cp src/install/java0.policy  $TARGET/etc
cp src/install/judge.conf  $TARGET/etc
chmod +x src/install/ans2out
if grep "OJ_SHM_RUN=0" etc/judge.conf ; then
	mkdir run0 run1 run2 run3
	chown judge run0 run1 run2 run3
fi
sed -i "s/OJ_HTTP_JUDGE=0/OJ_HTTP_JUDGE=1/g" etc/judge.conf
sed -i "s|OJ_HTTP_BASEURL=http://127.0.0.1/JudgeOnline|OJ_HTTP_BASEURL=$URL|g" etc/judge.conf
sed -i "s/OJ_HTTP_USERNAME=IP/OJ_HTTP_USERNAME=$USER/g" etc/judge.conf
sed -i "s/OJ_HTTP_PASSWORD=root/OJ_HTTP_PASSWORD=$PASSWORD/g" etc/judge.conf
sed -i "s/OJ_RUNNING=1/OJ_RUNNING=$CPU/g" etc/judge.conf
cd src/core
chmod +x ./make.sh
if [ ! -e /usr/bin/judged ] ; then
	bash ./make.sh
fi
/usr/bin/judged $TARGET

