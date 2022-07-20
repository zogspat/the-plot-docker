PHPVERSION=$(php -v | head -n 1 | cut -d " " -f 2 | cut -f1-2 -d".")
SIZELIMIT="400M"
sed -i "s/post_max_size.*/post_max_size = $SIZELIMIT/" /etc/php/$PHPVERSION/apache2/php.ini
sed -i "s/upload_max_filesize.*/upload_max_filesize = $SIZELIMIT/" /etc/php/$PHPVERSION/apache2/php.ini
