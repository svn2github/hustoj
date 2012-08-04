#summary modify Compiler Parameters
#labels Featured,Phase-Support
Because we are using GPL, you can easily modify complier parameters with judge_client.cc.

BUT!

 * to gcc/g++ ,--static and -lm cannot be remove.
 * to javac -Xmx -Xms should much lesser than limit setting in judge_client