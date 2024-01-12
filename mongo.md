# (slug: install-alpine)

`# if < alpine 3.6, add repository`
`echo 'http://dl-cdn.alpinelinux.org/alpine/v3.6/main' >> /etc/apk/repositories`
`echo 'http://dl-cdn.alpinelinux.org/alpine/v3.6/community' >> /etc/apk/repositories`
`apk update`
`apk add openrc`
`apk add mongodb`
`apk add mongodb-tools`
`rc-update add mongodb default`
`rc-service mongodb start`

# (slug: user-admin)

`use admin`
`db.createUser({user: "admin", pwd: "password", roles: [{ role: "userAdminAnyDatabase", db: "admin" }, "readWriteAnyDatabase"]})`


# (slug: creation,initialisation) Creation of a new database

`# in /etc/mongodb.conf`
`bind_ip = 0.0.0.0`
`port = 27017`
`logpath = /var/log/mongodb/mongod.log`
``
`mkdir -p /data/db /var/log/mongodb`
``
`mongod --config /etc/mongodb.conf`

# (slug: commands) Commands

`use dbs`

# (slug: user-creation)

`db.user.insert({name: "John", age: 205 })`
