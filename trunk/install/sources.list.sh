#!/usr/bin/bash

codename=`cat /etc/os-release | grep UBUNTU_CODENAME | awk -F '=' '{print $2}'`

mv /etc/apt/sources.list /etc/apt/sources.list.bak

cat >/etc/apt/sources.list <<EOF
# See http://help.ubuntu.com/community/UpgradeNotes for how to upgrade to
# newer versions of the distribution.
deb https://mirrors.aliyun.com/ubuntu/ ${codename} main restricted
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename} main restricted

## Major bug fix updates produced after the final release of the
## distribution.
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-updates main restricted
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename}-updates main restricted

## N.B. software from this repository is ENTIRELY UNSUPPORTED by the Ubuntu
## team. Also, please note that software in universe WILL NOT receive any
## review or updates from the Ubuntu security team.
deb https://mirrors.aliyun.com/ubuntu/ ${codename} universe
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename} universe
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-updates universe
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename}-updates universe

## N.B. software from this repository is ENTIRELY UNSUPPORTED by the Ubuntu 
## team, and may not be under a free licence. Please satisfy yourself as to 
## your rights to use the software. Also, please note that software in 
## multiverse WILL NOT receive any review or updates from the Ubuntu
## security team.
deb https://mirrors.aliyun.com/ubuntu/ ${codename} multiverse
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename} multiverse
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-updates multiverse
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename}-updates multiverse

## N.B. software from this repository may not have been tested as
## extensively as that contained in the main release, although it includes
## newer versions of some applications which may provide useful features.
## Also, please note that software in backports WILL NOT receive any review
## or updates from the Ubuntu security team.
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-backports main restricted universe multiverse
# deb-src https://mirrors.aliyun.com/ubuntu/ ${codename}-backports main restricted universe multiverse

## Uncomment the following two lines to add software from Canonical's
## 'partner' repository.
## This software is not part of Ubuntu, but is offered by Canonical and the
## respective vendors as a service to Ubuntu users.
# deb http://archive.canonical.com/ubuntu ${codename} partner
# deb-src http://archive.canonical.com/ubuntu ${codename} partner

deb https://mirrors.aliyun.com/ubuntu/ ${codename}-security main restricted
# deb-src https://mirrors.aliyun.com/ubuntu ${codename}-security main restricted
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-security universe
# deb-src https://mirrors.aliyun.com/ubuntu ${codename}-security universe
deb https://mirrors.aliyun.com/ubuntu/ ${codename}-security multiverse
# deb-src https://mirrors.aliyun.com/ubuntu ${codename}-security multiverse

# This system was installed using small removable media
# (e.g. netinst, live or single CD). The matching "deb cdrom"
# entries were disabled at the end of the installation process.
# For information about how to configure apt package sources,
# see the sources.list(5) manual.
EOF
