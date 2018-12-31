#!/bin/bash
g++ -o main main.cc
for i in `find -name "*.in"`
do 
	./main< $i > `basename -s ".in" $i`.out
done

