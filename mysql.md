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
