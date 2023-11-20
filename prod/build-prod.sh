#!/bin/bash
docker build --no-cache -t cheatsheet-app . -f ./prod/Dockerfile
docker tag cheatsheet-app harbor.morgan-thibert.com/cheatsheet-app/cheatsheet-app:prod
