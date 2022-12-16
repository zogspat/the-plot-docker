. /tmp/enVars.txt
envsubst '$DBNAME, $MYSQL_ROOT_PASSWORD, $MYSQL_PASSWORD' < /tmp/wp-config_in > /var/www/html/blog/wp-config.php
a2ensite default-ssl
apachectl -D FOREGROUND
