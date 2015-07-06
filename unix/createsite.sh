cd /home/$2
sudo mkdir $1

cd /etc/apache2/sites-available/

echo "<VirtualHost *:80>" | sudo tee $1.com
echo "ServerAdmin smjrifle@gmail.com" | sudo tee -a $1.com
echo "ServerName $1.com " | sudo tee -a $1.com
echo "# ServerAlias www.$1.com" | sudo tee -a $1.com
echo "DocumentRoot /home/$2/$1" | sudo tee -a $1.com

echo "<Directory />" | sudo tee -a $1.com
echo "AllowOverride All" | sudo tee -a $1.com
echo "</Directory>" | sudo tee -a $1.com

echo "<Directory /home/$2/$1>" | sudo tee -a $1.com
echo "AllowOverride All" | sudo tee -a $1.com
echo "</Directory>" | sudo tee -a $1.com

echo "ErrorLog /var/log/apache2/error.$1.com.log" | sudo tee -a $1.com
echo "LogLevel error" | sudo tee -a $1.com
echo "CustomLog /var/log/apache2/custom.$1.log custom" | sudo tee -a $1.com
echo "</VirtualHost>" | sudo tee -a $1.com

sudo a2ensite $1.com
sudo service apache2 reload

