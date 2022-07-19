# the-plot-docker

Backup of a blog based on a customised WordPress container. 

## Setup Steps:
1. Use the All-In-One Migration tool to export content. Note:
2. Create a .env file in the allInOneCompose directory with the following values:
DBNAME=
MYSQL_ROOT_PASSWORD=
MYSQL_PASSWORD=
HOSTNAME=
PRODUCTION=
EABKID=
EABHMACKEY=

3. Only the first three are needed but cp ~/allInOneCompose/.env ~/wpScratch/build.args
4. If neededed (current working version 1.6.1 in dockerhub) is In the wpScratch directory: docker build -t zogspat/wpscratch:version $(for i in `cat build.args`; do out+="--build-arg $i " ; done; echo $out;out="") .
5. docker push zogspat/wpscratch:version
6. Replace the hostnames in ~/allInOneCompose/init-letsencrypt.sh (2) and ~/allInOneCompose/data/nginx/app.conf (5)
7. Run ./init-letsencrypt.sh
8. Kill the Nginx container (not essential)
9. In /allInOneCompose, docker-compose up -d
