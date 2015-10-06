#!/bin/bash
filename='imagelist'
filelines=`cat $filename`
for line in $filelines ; do
    if [ -f = "full/"$line ]
	then
		echo $line
done
