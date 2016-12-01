#summary auto update shell script in LiveCD

= Introduction =

There is a shell script in the liveCD for auto update, put it here so someone can make use of it

no longer works because googlecode dead.

= Details =


#!/bin/bash
mkdir /fps
svn checkout http://hustoj.googlecode.com/svn/trunk/install /fps/install
svn checkout http://hustoj.googlecode.com/svn/trunk/core /fps/core
cd /fps/core
sudo pkill judged
sudo ./make.sh
sudo judged
cd /var/www/JudgeOnline/
sudo svn up .
apt-get clean
history -c

