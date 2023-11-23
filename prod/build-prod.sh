#!/bin/bash
docker build --no-cache -t cheatsheet-app . -f ./prod/Dockerfile
docker tag cheatsheet-app harbor.morgan-thibert.com/cheatsheet-app/cheatsheet-app:latest
# create a tag with the date of build for rollback if needed
DATE_TAG=$(date +%Y-%m-%d--%H-%M-%S)
docker tag cheatsheet-app harbor.morgan-thibert.com/cheatsheet-app/cheatsheet-app:$DATE_TAG
# upload on harbor
docker push harbor.morgan-thibert.com/cheatsheet-app/cheatsheet-app:latest
docker push harbor.morgan-thibert.com/cheatsheet-app/cheatsheet-app:$DATE_TAG
