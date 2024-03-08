# Installation with Bedrock

## Installation sans DDEV

```bash
composer create-project roots/bedrock
composer search wpackagist-plugin/akismet
composer require wpackagist-plugin/akismet
composer require roots/wordpress -W # upgrade wordpress to latest version
composer require wpackagist-theme/twentytwentythree # add theme
```
## Installation avec DDEV

```bash
mkdir my-app
cd my-app
ddev config --project-type=wordpress --docroot=web --create-docroot
ddev composer create roots/bedrock
ddev describe # view credentials
```
Add and replace in `.env` file : 

```.env
DB_NAME='db'
DB_USER='db'
DB_PASSWORD='db'
DB_HOST='db'
WP_HOME="${DDEV_PRIMARY_URL}"
```

Post-Install
```bash
composer require roots/acorn
cd web/app/themes
composer create-project roots/sage <theme-name>
npm install
npm run build
npm run dev
```

Change in `bud.config.js`:

```js
app
  .setUrl("http://127.0.0.1:3000")
  .setProxyUrl("https://<app.ddev.site>")
```
And access the site on `http://127.0.0.1:3000`


Start the server
```bash
ddev start
ddev ssh
wp core install --url=https://<ddev_site_url> --admin_user=<user> --admin_email=<email> --admin_password=<password>
```

Install plugins
```bash
composer require wpackagist-plugin
ddev ssh
wp plugin activate -all
```



The configuration equivalent to `wp-config.php` is `config/application.php`.
To install plugins as `mu-plugins`, update `composer.json` like this :

```json
{
  ...
  "extra": {
    "installer-paths": {
      "web/app/mu-plugins/{$name}/": ["type:wordpress-muplugin", "wpackagist-plugin/askimet", "wpackagist-plugin/trun-comments-off"],
      "web/app/plugins/{$name}/": ["type:wordpress-plugin"],
      "web/app/themes/{$name}/": ["type:wordpress-theme"]
    },
    "wordpress-install-dir": "web/wp"
  }
 ...
}
```

To add private repository, add it in `repository` and in `require` in `composer.json` and do `composer update`

```json
{
"repositories": [
  ...
    {
      "type": "vcs",
      "url": "git@github.com:YourGitHubUsername/example-plugin.git"
    }
  ...
  ],
"require": { "YourGitHubUsername/example-plugin": "2.9.1" }
...
}
```

## Nginx configuration for bedrock

```toml
server {
  listen 80;
  server_name example.com;

  root /srv/www/example.com/web;
  index index.php index.htm index.html;

  # Prevent PHP scripts from being executed inside the uploads folder.
  location ~* /app/uploads/.*.php$ {
    deny all;
  }

  location / {
    try_files $uri $uri/ /index.php?$args;
  }
}
```

# Interesting plugins and themes

## Themes

```bash
composer require wpackagist-theme/blankslate
ddev ssh
wp theme activate blankslate
wp theme delete twentytwentyfour
```

```bash
composer require wpackagist-plugin/turn-off-comments
composer require wpackagist-plugin/disable-gutenberg
composer require wpackagist-plugin/woocommerce
composer require wpackagist-plugin/wordpress-seo
composer require wpackagist-plugin/wp-fastest-cache
composer require wpackagist-plugin/advanced-custom-fields
composer require wpackagist-plugin/wps-hide-login
composer require wpackagist-plugin/wordfence

ddev ssh
wp plugin activate --all
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

wp db cli
wp db optimize
wp db search
wp db tables
wp db repair
wp db import
wp db export ~/wpdump.sql # save database
tar -vczf ~/backupwordpress /path/to/wordpress/site # backup wordpress files
```
