#!/bin/bash
str=" 0        1        2   3        45           6 7      8      9   q       w      e       r       t   y  u  o   pa  sd   fgh  jk lizxcvbnmQ WER   TY  U    O       P       A        S D    FG HJ        KLZX CV       B       NM"
color[0]='\E[30;40m'
color[1]='\E[31;40m'
color[2]='\E[34;40m'
color[3]='\E[37;40m'
clear
echo "hacking $1"
sleep 2
echo "Initializing"
sleep 2
echo "Server hacking module is loading"
sleep 2
echo "Server hacking module is ready"
sleep 2
echo "Hack module is starting in 5 seconds"
sleep 1
echo "4 seconds"
sleep 1
echo "3 seconds"
sleep 1
echo "2 seconds"
sleep 1
echo "1 seconds"
sleep 1
ping -c 3 $1
sleep 2
netstat
sleep 1
findsmb
sleep 1
for i in {1..10000}
do
  number1=$RANDOM
  let "number1 %= ${#str}"
  number2=$RANDOM
  let "number2 %=4"
  echo -n -e "\033[1m${color[$number2]}${str:number1:1}\033[0m"
done
sleep 3
echo "$1 succesfully hacked!"
sleep 1
echo "You are a terrible hacker dude"
