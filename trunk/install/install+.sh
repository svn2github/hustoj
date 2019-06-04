#!/usr/bin/bash

centos7=`cat /etc/os-release | grep PRETTY_NAME | grep CentOS | grep 7 `
ubuntu14=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 14`
ubuntu16=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 16`
ubuntu18=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 18`

# remind: centos7 doesn't install wget with minimal installation and ubuntu doesn't install curl by default !!!

if [ -n "${centos7}" ];then
    echo "CentOS7.* detected" ;
    sudo curl https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-centos7.sh | sudo bash ;
elif [ -n "${ubuntu14}" ];then
    echo "Ubuntu14.* detected" ;
    sudo apt-get -y install curl ;
    sudo curl https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu14.04.sh | sudo bash ;
elif [ -n "${ubuntu16}" ];then
    echo "Ubuntu16.* detected" ;
    sudo apt-get -y install curl ;
    sudo curl https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu16+.sh | sudo bash ;
elif [ -n "${ubuntu18}" ];then
    echo "Ubuntu18.* detected" ;
    sudo apt-get -y install curl ;
    sudo curl https://raw.githubusercontent.com/zhblue/hustoj/master/trunk/install/install-ubuntu18.04.sh | sudo bash ;
else
    echo "Not support yet system release"
fi