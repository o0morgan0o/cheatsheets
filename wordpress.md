# Installation with Bedrock

```bash
composer create-project roots/bedrock
composer search wpackagist-plugin/akismet
composer require wpackagist-plugin/akismet
composer require roots/wordpress -W # upgrade wordpress to latest version
composer require wpackagist-theme/twentytwentythree # add theme

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
