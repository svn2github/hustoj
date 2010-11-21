cd judged
make
cp judged /usr/bin
cd ../judge_client
make
cp judge_client /usr/bin
cd ../sim/sim_2_26
make sim_c
make sim_java
make sim_pasc
cp sim_c /usr/bin
cp sim_java /usr/bin/sim
cp sim_pasc /usr/bin/sim_pas
cd ..
cp sim.sh /usr/bin
ln -s /usr/bin/sim_c /usr/bin/sim_cc
