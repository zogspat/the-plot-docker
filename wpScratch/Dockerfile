FROM ubuntu

# https://stackoverflow.com/questions/20635472/using-the-run-instruction-in-a-dockerfile-with-source-does-not-work
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

#ENV MYSQL_ROOT_PASSWORD rootpasswd
# a couple of installs [mysql and php] need the interactive install disabled:

ENV TZ=Europe/London
ENV DEBIAN_FRONTEND=noninteractive
# possibly not needed with the command line setting of -h [and future equiv in docker-compose.yaml]
# ENV HOSTNAME=vps680267.ovh.net
#ENV MYSQL_USER=mysql

RUN apt-get update
RUN apt-get install -y apache2

# debug
RUN apt-get install -y iputils-ping
RUN apt-get install -y dnsutils

# for wp:
RUN apt-get install -y php
RUN apt-get install -y php-mysql
RUN apt-get install -y wget
RUN apt-get install -y nano

# change the php upload limit for php (for backup upload)
COPY changeUploadLimit.sh /tmp/changeUploadLimit.sh
RUN sh /tmp/changeUploadLimit.sh

RUN cd /var/www/html ; wget https://wordpress.org/latest.tar.gz ; gunzip latest.tar.gz ; tar -xf latest.tar ; chown -R www-data /var/www/html/wordpress; mv /var/www/html/wordpress /var/www/html/blog

# may not need this any more:
COPY 000-default.conf /etc/apache2/sites-available

COPY galleries.tar.gz /var/www/html/blog

# variable substitution in the wp-config file:
RUN apt-get install -y gettext
COPY wp-config.php /tmp/wp-config_in
# this whole approach is starting to look like less of a good idea: https://stackoverflow.com/questions/33548530/envsubst-command-getting-stuck-in-a-container
COPY build.args /tmp/enVars.txt

# It's possible that the RUN command to unzip the Wordpress install and the mv into the blog directory may not have completed.
RUN . /tmp/enVars.txt && envsubst '$DBNAME, $MYSQL_ROOT_PASSWORD, $MYSQL_PASSWORD' < /tmp/wp-config_in > /var/www/html/blog/wp-config.php
# ... so this may need to change to outputting to /tmp, and then copying the file on startup.

#RUN sudo /etc/init.d/mysql start; sudo mysql -u root -p rootpasswd < /tmp/setup.sql
COPY entrypoint.sh /tmp/entrypoint.sh
ENTRYPOINT ["/bin/bash", "/tmp/entrypoint.sh"]
