DROP USER 'root'@'localhost';
CREATE USER 'root'@'localhost' IDENTIFIED BY 'P1ngal1ng!';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
flush privileges
####
create database wordpress;
grant all privileges on *.* to 'wordy'@'localhost' identified by 'P1nkleP0nkle';
