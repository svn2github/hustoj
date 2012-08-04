#summary Tweak System to make optimize.
#labels Featured,Phase-Deploy,Phase-Support

= Introduction =

Except using DistributionSystem  , you can optimize your system to host a BIG contest.


= Details =

 1 install alternate php cache php-apc
{{{
sudo apt-get install php-apc
}}}
 2 tweak /etc/mysql/my.cnf  
for example, if you have more than 2G ram
{{{
[mysqld]
key_buffer              = 128M
query_cache_limit       = 4M
query_cache_size        = 128M
back_log                = 500
interactive_timeout     = 7200
max_connections         = 1024
thread_cache_size       = 80
wait_timeout            = 7200
tmp_table_size          = 128M
table_cache             = 256
}}}
  You can copy this to create a new file "/etc/mysql/conf.d/jol.cnf" , if you are using Ubuntu. *

 3 set judge.conf to use MultiRUNNING
{{{
 edit /home/judge/etc/judge.conf to set OJ_RUNNING=N (N>1)
 mkdirs run1,run2.....run(N-1) make sure the chown judge and chmod 755
 sudo pkill judged && sudo judged
 important: in most case N should be no more than you CPU number*4.
}}}
 4 cheat php to use memory for session
{{{
edit php.ini (/etc/php5/apache2/php.ini)
set session_save_path to somewhere under /dev/shm
or set session.save_handler=mm
}}}
 5 using /dev/shm for "JudgeOnline/cache" dir
{{{
  mkdir /dev/shm/cache
  ln -s /dev/shm/cache JudgeOnline/cache
}}}
 6 adjust the value of $cache_time in status.php
{{{
bigger value means slower pending but more efficient
smaller value means fast pending but less efficient 
}}}
 7 using /admin/updatedb.php to optimize tables structure.
{{{
Login with administrator privilige and access this page in admin menu.
}}}

= Test =
this test running no more then 10(half-page) pending on Dell D620 (1.83GHz CPUx2 1.5GRAM 80Gsata using Ubuntu10.4 LTS on ReiserFS)  with steps 1~3 only

{{{
#!/bin/bash
# use firebug to get the post data in file "post"
# and the SID
# change submit.php:124 to enable constant submit
# if (0&&mysql_num_rows($res)==1){

SID=[login with firebug to get this value for sessionid]

ab -c 300 -n 100000 http://127.1/JudgeOnline/status.php &
for i in {1..50}
do
   
   ab -q -c 10 -n 10 -T 'application/x-www-form-urlencoded' -p post -C PHPSESSID=$SID http://127.1/JudgeOnline/submit.php
   sleep 10

done

}}}

The test simulate 10 teams submit 1 solution per 10 seconds , while 300 others keep freshing status.php.