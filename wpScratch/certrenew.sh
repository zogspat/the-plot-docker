if [ $PRODUCTION = "true" ]

then 

  sh /tmp/acme.sh/acme.sh --renew  -d ${HOSTNAME} --webroot "/var/www/html"

else

  sh /tmp/acme.sh/acme.sh --staging --renew -d ${HOSTNAME} --webroot "/var/www/html"

fi

cp /root/.acme.sh/${HOSTNAME}/${HOSTNAME}.cer /etc/acme/acme-cert.pem
cp /root/.acme.sh/${HOSTNAME}/${HOSTNAME}.key /etc/acme/acme-key.key
apachectl restart
