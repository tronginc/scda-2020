sudo rm scda.sql.gz
sudo rm scda.zip
sudo mysqldump -u scdauser -p scda | sudo gzip > scda.sql.gz
sudo zip -r scda.zip * --exclude=wp-config.php
