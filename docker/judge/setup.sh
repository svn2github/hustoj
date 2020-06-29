set -xe

# Hustoj basic file system
useradd -m -u 1536 judge
mkdir -p /home/judge/etc
mkdir -p /home/judge/data
mv /trunk /home/judge/src
chmod -R 700 /home/judge/etc
chown -R www-data:www-data /home/judge/data

# Judge daemon and client
make      -C /home/judge/src/core/judged
make      -C /home/judge/src/core/judge_client
make exes -C /home/judge/src/core/sim/sim_3_01
cp /home/judge/src/core/judged/judged                /usr/bin/judged
cp /home/judge/src/core/judge_client/judge_client    /usr/bin/judge_client 
cp /home/judge/src/core/sim/sim_3_01/sim_c.exe       /usr/bin/sim_c
cp /home/judge/src/core/sim/sim_3_01/sim_c++.exe     /usr/bin/sim_cc
cp /home/judge/src/core/sim/sim_3_01/sim_java.exe    /usr/bin/sim_java
cp /home/judge/src/core/sim/sim.sh                   /usr/bin/sim.sh
cp /home/judge/src/install/hustoj                    /etc/init.d/hustoj
chmod +x /home/judge/src/install/ans2out
chmod +x /usr/bin/judged
chmod +X /usr/bin/judge_client
chmod +x /usr/bin/sim_c
chmod +X /usr/bin/sim_cc
chmod +x /usr/bin/sim_java
chmod +x /usr/bin/sim.sh

# Adjust system configuration
cp /home/judge/src/install/java0.policy  /home/judge/etc/
cp /home/judge/src/install/judge.conf    /home/judge/etc/
sed -i "s#OJ_COMPILE_CHROOT=1#OJ_COMPILE_CHROOT=0#g"     /home/judge/etc/judge.conf
sed -i "s#OJ_SHM_RUN=1#OJ_SHM_RUN=0#g"                   /home/judge/etc/judge.conf
