# Example load balancing application

```yaml
version: '3'

services:
  reverse-proxy:
    image: traefik:v2.2
    command: --api.insecure=true --providers.docker
    ports:
      - "80:80"
      - "8080:8080"
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
  
  nginx:
    image: nginx:alpine
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.nginx.rule=Host(`app`)"
      - "traefik.http.services.nginx.loadbalancer.server.port=80"

  apache:
    image: httpd:alpine
    labels:
      - "traefik.enable=true"
      - "traefik.http.routers.nginx.rule=Host(`app`)"
      - "traefik.http.services.nginx.loadbalancer.server.port=80"
```
