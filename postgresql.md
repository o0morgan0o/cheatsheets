# (slug: docker-postgres)
docker run -e POSTGRES_DB=app -e POSTGRES_PASSWORD=app -e POSTGRES_USER=app -p 5432:5432 postgres

# (slug: simple-connection)
psql -h localhost -p 5432 -U morgan my-database 
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
