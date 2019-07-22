This works, but needs some tidying up e.g.,
* set the cert renewal in cron
* pass in the hostname as an environment variable
* conditionality around staging vs production for LetsEncrypt
* checking volume persistance

Current working docker-compose.yaml, based on a local build of this image with...

docker build -t  zogspat/wpscratch:0.0.6 .

is vanilla:

version: '3.3'

services:
   db:
     image: mysql:5.7
     volumes:
       - db_data:/var/lib/mysql
     ports:
       - "3306:3306"
     restart: always
     environment:
       MYSQL_ROOT_PASSWORD: somewordpress
       MYSQL_DATABASE: wordpress
       MYSQL_USER: wordpress
       MYSQL_PASSWORD: wordpress

   wordpress:
     image: zogspat/wpscratch:0.0.7
     depends_on:
       - db
     volumes:
       - web_data:/var/www/html
     ports:
       - "80:80"
       - "443:443"
     restart: always
     environment:
       WORDPRESS_DB_HOST: db:3306
volumes:
    db_data: {}
    web_data: {}
