#mkdir -p /root/random
# the web server probably isn't running at this point but there is a 
# perms problem with the server.
apachectl -D FOREGROUND&
#sh /tmp/acme.sh --install --home /root/random --config-home /etc/acme
sh /tmp/acme.sh/acme.sh --staging --issue -d vps680267.ovh.net --webroot "/var/www/html"
cp /root/.acme.sh/vps680267.ovh.net/vps680267.ovh.net.cer /etc/acme/acme-cert.pem
cp /root/.acme.sh/vps680267.ovh.net/vps680267.ovh.net.key /etc/acme/acme-key.key
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

