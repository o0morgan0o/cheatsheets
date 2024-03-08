# Docker
```bash
docker run -it -p 27017:27017 -e MONGO_INITDB_ROOT_USERNAME=root -e MONTO_INITDB_ROOT_PASSWORD=password mongo
```


# Install Alpine

```bash
if < alpine 3.6, add repository
echo 'http://dl-cdn.alpinelinux.org/alpine/v3.6/main' >> /etc/apk/repositories
echo 'http://dl-cdn.alpinelinux.org/alpine/v3.6/community' >> /etc/apk/repositories

apk update
apk add openrc
apk add mongodb
apk add mongodb-tools
rc-update add mongodb default
rc-service mongodb start
```

# User Admin

```postgres-psql
use admin
db.createUser({user: "admin", pwd: "password", roles: [{ role: "userAdminAnyDatabase", db: "admin" }, "readWriteAnyDatabase"]})
```


# Creation of a new database

```bash
vi /etc/mongodb.conf
bind_ip = 0.0.0.0
port = 27017
logpath = /var/log/mongodb/mongod.log
```
ensuite

```bash
mkdir -p /data/db /var/log/mongodb
mongod --config /etc/mongodb.conf
```

# Commands

```postgres-psql
use dbs
db.getName() # see current db
show tables
db.employee.find()
```

# User Creation

```bash
db.user.insert({name: "John", age: 205 })
```


# Backup and restore

```bash
mongodump --uri="mongodb://<user>:p<password>@<ip>:27017" --out=/data/backup/
mongodump --uri="mongodb://<user>:p<password>@<ip>:27017" --out=/data/backup/ --db=test
mongorestore --uri=mongodb://<user>:p<password>@<ip>:27017 /data/backup/
```
