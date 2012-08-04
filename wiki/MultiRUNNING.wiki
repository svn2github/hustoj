#summary how to use judge.conf OJ_RUNNING
#labels Featured,Phase-Support

= Introduction =

judge.conf can set OJ_RUNNING to run multi-judger on one machine


= Details =

to improve OJ speed
  * edit /home/judge/etc/judge.conf to set OJ_RUNNING=N (N>1)
  * mkdirs run0,run1,run2.....run(N-1) make sure the chown judge and chmod 755
  * sudo pkill -9 judged && sudo judged

* important: in most case N should be no more than you CPU number*4.