# Connection
```bash
docker run -e MYSQL_ROOT_PASSWORD=password -e MYSQL_DATABASE=app -p 3306:3306 mysql:latest
mysql -h 127.0.0.1 -u root -p
```

#  Basic Database
```bash
mysql -u root -p
create database <db>;
create user '<user>'@'127.0.0.1' identified by '<password>';
grant all privileges on <db>.* to '<user>'@'127.0.0.1';
```

# MariaDB

```bash
apt install mariadb-server
mariadb-secure-installation
mysql -u root -p
CREATE DATABASE <db>;
CREATE USER '<user>'@'%' IDENTIFIED BY '<password>';
GRANT ALL PRIVILEGES ON <db>.* TO '<user>'@'%';
flush privileges;

DROP user '<user>@'localhost';
SELECT user FROM mysql.user;

```

To listen on all interfaces, add in `/etc/mysql/my.cnf`:
```toml
bind-address = 0.0.0.0
```
