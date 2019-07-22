FROM ubuntu
#ENV MYSQL_ROOT_PASSWORD rootpasswd
# a couple of installs [mysql and php] need the interactive install disabled:

ENV TZ=Europe/London
ENV DEBIAN_FRONTEND=noninteractive
# possibly not needed with the command line setting of -h [and future equiv in docker-compose.yaml]
# ENV HOSTNAME=vps680267.ovh.net
#ENV MYSQL_USER=mysql

RUN apt-get update
RUN apt-get install -y apache2

# Set up the cron job to try to renew the cert (once a month):
RUN apt-get install -y cron
COPY certrenew.sh /tmp/certrenew.sh
COPY croncertcmd.txt /etc/cron.d/croncertcmd.txt

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/croncertcmd.txt

# Apply cron job
RUN crontab /etc/cron.d/croncertcmd.txt

#RUN a2enmod rewrite
#RUN apt-get install -y mysql-server
# debug
RUN apt-get install -y iputils-ping
RUN apt-get install -y dnsutils

# for acme.sh:
RUN apt-get install -y wget
RUN apt-get install -y git
# for mysql setup:
RUN apt-get install -y sudo
# for wp:
RUN apt-get install -y php
RUN apt-get install -y php-mysql

# for python cronjob:
RUN apt-get install -y python python-pip
# pip needs to be able to have access to a real name server:
#RUN echo "nameserver 8.8.8.8" >> /etc/resolv.conf
RUN pip install requests
# sys os re collections smtplib time requests json
COPY logChecker.py /tmp/logChecker.py

# change the php upload limit for php (for backup upload)
COPY changeUploadLimit.sh /tmp/changeUploadLimit.sh
RUN sh /tmp/changeUploadLimit.sh

RUN  mkdir -p /etc/acme
RUN cd /var/www/html ; wget https://wordpress.org/latest.tar.gz ; gunzip latest.tar.gz ; tar -xf latest.tar ; chown -R www-data /var/www/html/wordpress; mv /var/www/html/wordpress /var/www/html/blog

COPY default-ssl.conf /etc/apache2/sites-available
COPY 000-default.conf /etc/apache2/sites-available
RUN a2enmod ssl
RUN cd /tmp ; git clone https://github.com/Neilpang/acme.sh.git; cd acme.sh ; chmod a+x acme.sh;

COPY galleries.tar.gz /var/www/html
RUN cd /var/www/html; gunzip galleries.tar.gz; tar -xf galleries.tar


#RUN sudo /etc/init.d/mysql start; sudo mysql -u root -p rootpasswd < /tmp/setup.sql
COPY entrypoint.sh /tmp/entrypoint.sh
ENTRYPOINT ["/bin/bash", "/tmp/entrypoint.sh"]
#CMD ["/usr/bin/mysqld_safe"]
