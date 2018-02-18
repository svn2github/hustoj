#!/bin/bash
cd judged
make
cd ../judge_client
make
cd ../sim/sim_3_01
make fresh
make exes
