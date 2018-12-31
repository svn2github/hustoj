#!/bin/bash
g++  -o main main.cc
for i in `find -name "*.in"`
do 
	if	./main< $i > `basename -s ".in" $i`.out 
	then
		echo "$i ok.";
	else
		echo "$i error!"
	fi
done

