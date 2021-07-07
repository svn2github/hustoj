#!/bin/bash
MAX="20"
if [ -n "$1" ]; then
	MAX=$1
fi

for i in `seq 1 $MAX`
do 

	echo $i
	if [ $i -lt 10 ]; then
		 mv "ex_input$i.txt" "data0$i.in"
		 mv "ex_output$i.txt" "data0$i.out"
	else
		 mv "ex_input$i.txt" "data$i.in"
		 mv "ex_output$i.txt" "data$i.out"

	fi

done
