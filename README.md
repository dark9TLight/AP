cd /var/www/html/AP

# Start services (run these each time you open WSL2)
sudo service mysql start
sudo service apache2 start

# Check service status
sudo service mysql status
sudo service apache2 status
