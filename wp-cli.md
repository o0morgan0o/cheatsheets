# Basic réinstallation

```bash
wp core download
wp config create --dbname=<db> --dbuser=<user> --dbpass=<pass> --dbhost=<host:port> --config-file=/path/to/output/wp-config.php
wp core install --url=<http://url.com> --title=<title> --admin_user=<user> --admin_password=<password> --admin_email=<email>
wp plugin install --activate all-in-one-wp-migration
wp plugin install --activate /path/to/plugin.zip

wp ai1wm list-backups
wp ai1wm restore backup --yes

wp rewrite flush
```

# All Cache plugins
```bash
#Flush the object cache using this WP-CLI command.
wp cache flush

#Beaver Builder plugin and Beaver Theme have these WP-CLI commands.
wp beaver clearcache
wp beaver theme clearcache
wp beaver clearcache --all

#Autoptimize plugin has this WP-CLI command.
wp autoptimize clear

#Cache Enabler plugin has this WP-CLI command.
wp cache-enabler clear

#Elementor plugin has this WP-CLI command.
wp elementor flush_css

# WP Fastest Cache plugin has these WP-CLI commands.
wp fastest-cache clear all
wp fastest-cache clear all and minified

#Swift Performance plugin has this WP-CLI command.
sp_clear_all_cache

#W3 Total Cache plugin has these WP-CLI commands.
w3-total-cache cdn_purge
wp w3-total-cache flush all

#WP Rocket plugin has a community package for WP-CLI support.
https://github.com/GeekPress/wp-rocket-cli
wp rocket clean --confirm

#WP Super Cache plugin has a community package for WP-CLI support.
https://github.com/wp-cli/wp-super-cache-cli
wp super-cache flush
```
