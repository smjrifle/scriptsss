i=0
for name in `ls *.zip`
do
  unzip $name -d $i
  i=$(($i+1))
done
