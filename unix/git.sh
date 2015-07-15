#!/bin/zsh
   git status
     read -p "Do you want to push: " yn
       case $yn in
         [Yy]* ) git add -A;git commit -m $1;git pull origin master;git push origin master; break;;
           [Nn]* ) exit;;
             * ) echo "Please answer yes or no:: ";;
               esac
