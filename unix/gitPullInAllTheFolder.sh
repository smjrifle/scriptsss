home=/root/*/ # here */ represents the directory, you can also use ls -d */ in for loop but have to insert in the folder you want to execute
for name in `ls -d $home`
do
  START=$(date +%s)
  git pull $name
  END=$(date +%s) 
  DIFF=$(( $END - $START ))
  echo "Git Pull done in $name. Time Taken: $DIFF. Finished on:" $(date)
done
