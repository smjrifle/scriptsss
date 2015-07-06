#99littlebugsong
#/bin/zsh
number=30
echo "Project Started\n"
while :
do
  sleep 1
  echo  "$number little bugs in the code,\n$number little bugs in the code,\n\
    fix one bug,compile it again,"
  j=$[ ($RANDOM % 10) + 1 ]
  if [ $number -lt 1 ]
  then
    break;
  elif [ `expr $j % 2` -eq 0 ]
  then
    number=$((number+$j))
  else
    number=$((number-$j))
  fi
done
echo "\nProject End"
