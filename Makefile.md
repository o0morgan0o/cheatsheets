# (slug: basic-setup)
```
help: ## 
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'
run install-all: ##
	cd api && npm install && cd ../web && npm install
run-docker-database: ##
	cd api && docker compose up
```
