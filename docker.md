# Database
```bash
docker run -e POSTGRES_DB=app -e POSTGRES_PASSWORD=app -e POSTGRES_USER=app -p 5432:5432 postgres
```

# Debug build
```bash
docker build -t app . -f ./app/Dockerfile --no-cache --progress plain
```
