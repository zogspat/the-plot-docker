# the web server probably isn't running at this point but there is a
# perms problem with the server.
apachectl -D FOREGROUND&

# It would be less messy to have different filenames for the staging and
# prod certs. One to come back to...

if [ ! -f /root/.acme.sh/${HOSTNAME}/${HOSTNAME}.cer ] && [ $PRODUCTION = "true" ] ; then

  sh /tmp/acme.sh/acme.sh --issue -d ${HOSTNAME} --webroot "/var/www/html"
  touch /tmp/prodcert

fi

if [ $PRODUCTION = "false" ] && [ ! -f /tmp/prodcert ] ; then

    sh /tmp/acme.sh/acme.sh --staging --issue -d ${HOSTNAME} --webroot "/var/www/html"

fi

cp /root/.acme.sh/${HOSTNAME}/${HOSTNAME}.cer /etc/acme/acme-cert.pem
cp /root/.acme.sh/${HOSTNAME}/${HOSTNAME}.key /etc/acme/acme-key.key
apachectl stop
# can't run this in the Dockerfile, because the cert the SSL config file references wouldn't
# be there yet:
a2ensite default-ssl
#service mysql restart
#sudo service mysql restart
#sudo mysql -u root -p rootpasswd <  /tmp/setup.sql
# Not sure why this is needed, but the docker logs are complaining without it and ssl doesn't work:
service apache2 reload
apachectl -D FOREGROUND
