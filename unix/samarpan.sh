while (true) do

  for i in `cat smj ` ; do echo "$RANDOM .$i " ; done |  sort -rn | awk '{print $2}' | sed -e '1{$p;x;d;}' -e '/^NEW/!{H;$!d;x;s/\n//g;b;}' -e 'x;s/\n//g;${p;x;}' | sed 's/\./ /g'
done
