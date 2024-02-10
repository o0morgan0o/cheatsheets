# (slug: Install-and-config)
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

# (slug: grant-all-privileges)
grant pg_read_all_data to <user>;
grant pg_write_all_data to <user>;

# (slug: docker-postgres)
docker run -e POSTGRES_DB=app -e POSTGRES_PASSWORD=app -e POSTGRES_USER=app -p 5432:5432 postgres

# (slug: simple-connection)
psql -h localhost -p 5432 -U morgan my-database 
postgres://user:secret@localhost:5432/mydatabasename
psql --list

# (slug: commandes)
\list
CREATE DATABASE test-database;
\connect test-database;
\conninfo
\d mytable;
DROP DATABASE test;

# (slug: permissions)
ALTER DATABASE my_db OWNER TO my_user;
GRANT ALL ON ALL TABLES IN SCHEMA public to my_user;
GRANT ALL ON ALL SEQUENCES IN SCHEMA public to my_user;
GRANT ALL ON ALL FUNCTIONS IN SCHEMA public to my_user;
