#!/bin/bash
#git with auto pull
#check if parameter is sent, parameter should be the name of git repo and site you wanna create
 
if [ "$#" -eq 1 ]
 
then
 
echo "Ok , I am creating git repo $1.git"
cd /home/git
sudo mkdir $1.git
 
cd $1.git
#create bare git repo
sudo git init --bare
#configure the repo
sudo git --bare update-server-info
 
sudo git config core.bare false
 
sudo git config receive.denycurrentbranch ignore
#set the working tree, the place where the code is to be auto pushed
sudo git config core.worktree /var/www/$1
 
cd ..
 
sudo chown git:www-data $1.git -R
cd $1.git
#now create a post hook event for git repo, for auto pull
sudo echo "#!/bin/sh" |  tee hooks/post-receive
 
sudo echo "git checkout -f" |  tee -a hooks/post-receive
 
sudo chmod +x hooks/post-receive
 
else
#no parameter is passed, so exit the script
echo "Please ask what is the file name"
 
exit
fi
 
#now creating virtual host, assuming your webserver directory is /var/www clone the site first
cd /var/www/
git clone git@yoursite.com:$1.git $1
cd $1
sudo chown git:www-data -R .
#add site to virtual host
cd /etc/apache2/sites-available/
 
echo "" | sudo tee $1.yoursite.com
echo "ServerAdmin user@yoursite.com" | sudo tee -a $1.yoursite.com
echo "ServerName $1.yoursite.com " | sudo tee -a $1.yoursite.com
echo "# ServerAlias www.$1.yoursite.com" | sudo tee -a $1.yoursite.com
echo "DocumentRoot /var/www/$1" | sudo tee -a $1.yoursite.com
 
echo "" | sudo tee -a $1.yoursite.com
echo "AllowOverride All" | sudo tee -a $1.yoursite.com
echo "" | sudo tee -a $1.yoursite.com
 
echo "" | sudo tee -a $1.yoursite.com
echo "AllowOverride All" | sudo tee -a $1.yoursite.com
echo "" | sudo tee -a $1.yoursite.com
echo "ErrorLog /var/log/apache2/error.$1.com.log" | sudo tee -a $1.yoursite.com
echo "LogLevel error" | sudo tee -a $1.yoursite.com
echo "CustomLog /var/log/apache2/custom.$1.log custom" | sudo tee -a $1.yoursite.com
echo ""  | sudo tee -a $1.yoursite.com
#enable site and restart apache
sudo a2ensite $1.yoursite.com
sudo service apache2 reload
 
#Show info to add/clone repo also log the creation on gitLog folder
echo "Created git repo for $1.git"
 
echo "You can clone the repo using git clone git@yoursite.com:$1.git"
 
echo "or you can add your codes to repo using git remote add origin git@yoursite.com:$1.git"
 
echo "git@yoursite.com:$1.git created on " >> gitLog $(date)
cd ~