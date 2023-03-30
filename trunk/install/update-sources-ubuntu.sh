#!/bin/bash
# Official
sed -i 's@//.*archive.ubuntu.com@//mirrors.aliyun.com@g' /etc/apt/sources.list
sed -i 's@//security.ubuntu.com@//mirrors.aliyun.com@g' /etc/apt/sources.list

# Tencent Cloud
sed -i 's@//mirrors.tencentyun.com@//mirrors.aliyun.com@g' /etc/apt/sources.list

apt update
