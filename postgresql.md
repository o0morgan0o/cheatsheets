# Install And Config
```bash
apt install postgresql
su - postgres
psql
create user <user> with password '<password>';
create database <db>;
alter database <db> owner to <user>;
grant all on tables in schema public to <user>;
grant all on sequences in schema public to <user>;
grant all on all functions in schema public to <user>;
vi /etc/postgresql/15/main/postgresql.conf # => change listen_addresses
vi /etc/postgresql/15/main/pg_hba.conf # => change IPv4 connections
systemctl restart postgresql
```

# Grant All Privileges
```bash
grant pg_read_all_data to <user>;
grant pg_write_all_data to <user>;
```

# Docker Postgres
```bash
docker run -e POSTGRES_DB=app -e POSTGRES_PASSWORD=app -e POSTGRES_USER=app -p 5432:5432 postgres
```

# Simple Connection
```bash
psql postgres://user:secret@host:5432/my-database
psql -h localhost -p 5432 -U morgan my-database 
postgres://user:secret@localhost:5432/mydatabasename
psql --list
```

# Commandes
```bash
\list
CREATE DATABASE test-database;
\connect test-database;
\conninfo
\d mytable;
DROP DATABASE test;
```

# Permissions
```bash
ALTER DATABASE my_db OWNER TO my_user;
GRANT ALL ON ALL TABLES IN SCHEMA public to my_user;
GRANT ALL ON ALL SEQUENCES IN SCHEMA public to my_user;
GRANT ALL ON ALL FUNCTIONS IN SCHEMA public to my_user;
```
