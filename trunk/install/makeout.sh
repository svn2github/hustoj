#!/bin/bash
if [ "$1" = "" ]; then
   echo "Usage: $0 standard-execute-binary"
   echo "Example: after compiled your standard program by 'gcc -o main main.cc' "
   echo "         TYPE ---> '$0 main' "
   echo "         will generate .out files for each .in files in "`pwd`
   exit 1
fi
EXEC=./$1
for INFILE in `ls *.in`
do
        OUTFILE=`basename -s .in $INFILE`.out
        if $EXEC < $INFILE > $OUTFILE ; then
                echo "make out for $INFILE -> $OUTFILE <br>"
        else
                echo "make out for $INFILE .....failed"
        fi
done

