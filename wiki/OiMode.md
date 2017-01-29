#summary Olympics-Information Mode usage
#labels Featured
= Introduction =

Olympics-Information is a game like ACM/ICPC, Oi-mode is designed to adjust hustoj for OI exercise.



= Details =
to enable OI mode :
  * upgrade core and web to SVN version r1210 +
  * upgrage judge.conf to SVN version r1210 +
  * enable oi mode in judge.conf with OJ_OI_MODE=1
  * recompile the core with "pkill judged && ./make.sh" in core dir

after enabled OI mode:
  * all test cases will be tested no matter if any test is fail
  * non-Accepted result will be followed by a percentage of pass-rate if parts of tests has been passed.
  * Contest ranks and exercise ranks will not change by OI mode, pass-rate is only promoted in status.php.
  * Time limit in problem is case-time-limit for each test case rather than total time limit.