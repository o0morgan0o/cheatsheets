# Install And Config
```bash
apt install postgresql
su - postgres
psql
create user <user> with password '<password>';
create database <db>;
alter database <db> owner to <user>;
grant all on all tables in schema public to <user>;
grant all on all sequences in schema public to <user>;
grant all on all functions in schema public to <user>;
vi /etc/postgresql/15/main/postgresql.conf # => change listen_addresses
vi /etc/postgresql/15/main/pg_hba.conf # => change IPv4 connections
systemctl restart postgresql
```

# Common data folders
```bash
/var/lib/postgresql/MAJOR_RELEASE/main # => Debian / Ubuntu
/var/lib/pgsql/data # RedHat / CentOS / Fedora
C:\Program Files\PostgreSQL\MAJOR_RELEASE\data
SHOW data_directory;
pg_config
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

# Table
```sql
CREATE TABLE orders ( orderid integer PRIMARY KEY );
CREATE TABLE orderlines ( orderid integer, lineid smallint, PRIMARY KEY (orderid, lineid) );
ALTER TABLE orderlines ADD FOREIGN KEY (orderid) REFERENCES orders (orderid);
DROP TABLE orders;
\d+ # voir les relations
SELECT * FROM pg_constraint WHERE confrelid = 'orders'::regclass; # voir les relations
```

# Commandes
```bash
\?
\h
\password # pour changer le password du user
\list
CREATE DATABASE test-database;
\connect test-database;
\conninfo
\d mytable;
DROP DATABASE test;
```

# Commandes (Suite)
```sql
SELECT current_database();
SELECT current_user;
SELECT version();
SELECT current_time;
SELECT pg_database_size(current_database());
SHOW data_directory;
```

# Passwords
```sql
SET password_encryption = 'scram-sha-256';
\password
ALTER USER myuser PASSWORD 'secret';
```

# Permissions
```bash
ALTER DATABASE my_db OWNER TO my_user;
GRANT ALL ON ALL TABLES IN SCHEMA public to my_user;
GRANT ALL ON ALL SEQUENCES IN SCHEMA public to my_user;
GRANT ALL ON ALL FUNCTIONS IN SCHEMA public to my_user;
```

# Example util commands
```sql
SELECT count(*) FROM information_schema.tables WHERE table_schema NOT IN ('information_schema','pg_catalog'); # compte le nombre de tables
SELECT sum(pg_database_size(datname)) from pg_database; # taille occupée par toutes les db
SELECT count(*) FROM table;
SELECT * FROM pg_extension;
```

# Docker compose

```yaml
version: '3.9'

services:
  postgres:
    image: postgres:14-alpine
    ports:
      - 5432:5432
    volumes:
      - ./db-data:/var/lib/postgresql/data
    environment:
      - POSTGRES_PASSWORD=password
      - POSTGRES_USER=app
      - POSTGRES_DB=app
```
