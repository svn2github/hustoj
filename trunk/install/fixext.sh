#!/bin/bash
# fixing data  reward.in1  reward.ou1 
# usage 
MAX="20"
MAIN="reward"
if [ -n "$1" ]; then
	MAIN=$1
else
	echo  "fixing filenames"
	echo  "usage: $0 <mainfilename>"
	echo  "example: $0 reward"
	exit 1;
fi

for i in `seq 1 $MAX`
do 

	echo $i
	if [ $i -lt 10 ]; then
		 mv "$MAIN.in$i" "data0$i.in"
		 mv "$MAIN.ou$i" "data0$i.out"
	else
		 mv "$MAIN$i.txt" "data$i.in"
		 mv "$MAIN$i.txt" "data$i.out"

	fi

done
