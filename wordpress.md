# Installation with Bedrock

```bash
composer create-project roots/bedrock
composer require wpackagist-plugin/askimet
composer require roots/wordpress -W # upgrade wordpress to latest version
composer require wpackagist-theme/twentytwentythree # add theme
```

# Wpcli

```bash
wp core install --url=http://site.com --title=my-site --admin_user=<user> --admin_password=<password> --admin_email=<email>
wp plugin uninstall --deactivate akismet
wp plugin install --activate all-in-one-wp-migration
wp plugin list
wp theme delete twentytwentyone twentytwentytwo

wp ai1wm backup --exclude-media --exclude-themes --exclude-inactive-themes# restore backup
wp ai1wm restore backup-20180105-142530-313.wpress
wp rewrite flush

wp core update
wp plugin update --all
```
