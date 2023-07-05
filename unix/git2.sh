#!/bin/zsh
if [ "$#" -lt 1 ] 
  then
  echo "No commit message given give one now"
  read a 
else
  a=$1
fi
if [ "$#" -eq 2 ] 
  then
  b=$2 
else
  b="master"
fi
git status
read -p "Do you want to push: " yn
case $yn in
 [Yy]* ) git add -A;git commit -m "${a}";git pull origin $b;git push origin $b; break;;
[Nn]* ) exit;;
* ) echo "Please answer yes or no:: ";;
esac
