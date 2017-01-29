#summary for situation described by issue60
#labels Featured,Phase-Support

= Introduction =

security patch, helpful side keeper


= Details =

==Use iptables for network blocking==
use this line

iptables -A OUTPUT -m owner --uid-owner judge -j DROP

to block any network out going ip package from judge_client(not include PING)
REMEMBER to save it using
http://www.cyberciti.biz/faq/how-do-i-save-iptables-rules-or-settings/

==Update all code to at least r1371==
for livecd users try

sudo update-hustoj


==Disable Unused Language==
edit /var/www/JudgeOnline/include/db_info.inc.php

$OJ_LANGMASK=1008; //for C/CPP/Pascal/Java only
