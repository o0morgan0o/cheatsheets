# (slug: databases) Database
```
docker run -e POSTGRES_DB=app -e POSTGRES_PASSWORD=app -e POSTGRES_USER=app -p 5432:5432 postgres
```

# (slug: debug-build)
```
docker build -t app . -f ./app/Dockerfile --no-cache --progress plain
```
