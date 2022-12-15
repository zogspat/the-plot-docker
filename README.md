# the-plot-docker

Backup of a blog based on a customised WordPress container. (This is tailored to the point of not being of general interest.)

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

3. Only the first three are needed but cp ~/the-plot-docker/allInOneCompose/.env ~/the-plot-docker/wpScratch/build.args
4. If neededed (current working version 1.6.1 in dockerhub) is In the wpScratch directory: 
5. For test purposes, touch galleries.tar.gz in the wp-scratch directory.
6. docker build -t zogspat/wpscratch:version $(for i in `cat build.args`; do out+="--build-arg $i " ; done; echo $out;out="") .
7. (When it's working, docker push zogspat/wpscratch:version)
8. Make sure the build version matches the image version for wordpress in ~/the-plot-docker/allincompose/docker-compose.yaml
9. Replace the hostnames in ~/allInOneCompose/init-letsencrypt.sh (2 instances) and ~/the-plot-docker/allInOneCompose/data/nginx/app.conf (5)
10. Run ~/the-plot-docker/allInOneCompose/init-letsencrypt.sh . Note: toggle Staging value for testing purposes.
11. Kill the Nginx container (not essential)
12. Mailserver needs at least one account: in ~/mailserver run setup.sh email add account@domain.com password
13. Note the install paths for mail server volumes (see also below)
14. Copy the static gallery file into the ~/allInOneCompose directory; uncomment the COPY command in the docker compose file.
15. In ~/allInOneCompose, docker-compose up -d

## Notes on test vs production certs
The naming conventions for test vs prod certs is handled very differently. Prod uses symlinks to point to files that always have the same name (privkey.pem etc), and are in an 'archive' directory. Testing creates files only in the live directory, and which start withthe sitename (TBC). This makes it messy to refer to them in the mailserver configuration.
