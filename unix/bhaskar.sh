if [ "$#" -eq 1 ]
  then
  sudo mkdir $1
  cd $1
  sudo git init --bare
  cd ..
  sudo chown git:git $1 -R
  sudo chmod 775 -R $1
  echo "Created git repo for $1"
  echo "You can clone the repo using git clone git@bhaskar.com:$1"
  echo "or you can add your codes to repo using git remote add origin git@bhaskar.com:$1"
else
  echo "Please pass the filename"
fi
~                                                                               
~                     
