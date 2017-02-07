#summary Install More Programming Language Support other than C/CPP
#labels Featured
= Introduction =

After standard installation C/CPP should already installed, because the core itself is using gcc/g++.

HUSTOJ support more programming languages :
  * Pascal
  * Java
  * Ruby
  * Bash
  * Python

= Details =

  * Pascal

sudo apt-get install fpc

  * Java

sudo apt-get install openjdk-6-jdk

  * Ruby

sudo apt-get install ruby

  * Python

sudo apt-get install python

  * Objective C

sudo apt-get install gnustep gnustep-devel gobjc

  * FreeBasic32bits
install follow 
http://www.freebasic.net/get
and then

sudo apt-get install libncurses5-dev

finally you need to change $OJ_LANGMASK

https://github.com/zhblue/hustoj/blob/master/trunk/web/include/db_info.inc.php#L21

each bit is used for disabling certain language.
