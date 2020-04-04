#!/bin/bash

sed -i s/http\:\/\/cn.archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g /etc/apt/sources.list
sed -i s/http\:\/\/archive.ubuntu.com/https\:\/\/mirrors.aliyun.com/g    /etc/apt/sources.list
sed -i s/http\:\/\/security.ubuntu.com/https\:\/\/mirrors.aliyun.com/g   /etc/apt/sources.list

apt update
