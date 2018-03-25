CPU Compensation
==================
HUSTOJ has been used in some system for more than 9 years.
Whole system need to be migrated to new platforms, which could be way more fast than the original server

therefore, in judge.conf , a new parameter called OJ_CPU_COMPENSATION is introduced to adjust the outcome of judge.

by default , 1.0 means no adjust.
if your new CPU core is as 2x fast as the old one, set OJ_CPU_COMPENSATION=2.0
if your new CPU core is as half fast as the old one, set OJ_CPU_COMPENSATION=0.5

by setting it correctly, you might find less time limit adjusting for each "problem" is required during the migration.

still , you can use it to fake your high-end CPU to be a low-end one by setting it to 10.0.
or , fake your milti-cores low-end CPU to be a high-speed core by setting it to 0.05.
