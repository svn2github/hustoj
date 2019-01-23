#!/usr/bin/bash

centos7=`cat /etc/os-release | grep PRETTY_NAME | grep CentOS | grep 7 `
ubuntu14=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 14`
ubuntu16=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 16`
ubuntu18=`cat /etc/os-release | grep PRETTY_NAME | grep Ubuntu | grep 18`

if [ -n "${centos7}" ];then
    own=apache;
elif [ -n "${ubuntu14}" ];then
    own=judge;
elif [ -n "${ubuntu16}" ];then
    own=www-data;
elif [ -n "${ubuntu18}" ];then
    own=www-data;
fi