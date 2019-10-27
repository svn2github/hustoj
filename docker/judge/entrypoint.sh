set -xe

CPU=`grep "cpu cores" /proc/cpuinfo |head -1|awk '{print $4}'`

sed -i "s#OJ_HOST_NAME=127.0.0.1#OJ_HOST_NAME=$HOSTNAME#g" /home/judge/etc/judge.conf
sed -i "s#OJ_USER_NAME=root#OJ_USER_NAME=$USERNAME#g"      /home/judge/etc/judge.conf
sed -i "s#OJ_PASSWORD=root#OJ_PASSWORD=$PASSWORD#g"        /home/judge/etc/judge.conf
sed -i "s#OJ_RUNNING=1#OJ_RUNNING=$CPU#g"                  /home/judge/etc/judge.conf

chown -R www-data:www-data /home/judge/data

RUNNING=`cat /home/judge/etc/judge.conf | grep OJ_RUNNING`
RUNNING=${RUNNING:11}
for i in `seq 1 $RUNNING`; do
    mkdir -p    /home/judge/run`expr ${i} - 1`;
    chown judge /home/judge/run`expr ${i} - 1`;
done 

service hustoj start

while true; do sleep 1; done