#!/bin/bash

sed -i 's/http\:\/\/il.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/us.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/cn.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/fr.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/in.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/np.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/fi.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/th.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/ru.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/md.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/ch.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/se.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/no.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/nl.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/am.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/dk.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/is.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/ua.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/ge.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/nz.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/cr.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/hk.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/gb.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/us-east-1.ec2.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/cz.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/id.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/es.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/my.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/us-west-2.ec2.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/za.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/sk.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/ph.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/hr.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/us-east-1a.clouds.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/eu-west-2.ec2.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/gl.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/jp.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/jo.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/pt.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g' /etc/apt/sources.list
sed -i 's/http\:\/\/archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g'    /etc/apt/sources.list

sed -i 's/http\:\/\/security.ubuntu.com/https\:\/\/mirrors.aliyun.com/g'   /etc/apt/sources.list

# Tencent Cloud

sed -i 's/http\:\/\/mirrors.tencentyun.com/https\:\/\/mirrors.aliyun.com/g'   /etc/apt/sources.list

apt update
