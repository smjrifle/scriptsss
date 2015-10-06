if [ "$#" -eq 3 ] 
  then
  echo "Make sure you have forage and forage-indexer installed"
  sudo mongoexport --jsonArray -d $1 -c $2 -o $3
else
  echo "Please pass correct arguments, DBName, Table Name, and Path of output file"
fi
