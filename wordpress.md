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
cd <theme-name>
npm install
npm run build
npm run dev
```

Change in `bud.config.js`:

```js
app
   .setPublicPath("/app/themes/<theme>/public/");
app
  .setUrl("http://127.0.0.1:3000")
  .setProxyUrl("https://<app.ddev.site>")
```
And access the site on `http://127.0.0.1:3000`.

Change in `.ddev/config.yml`:
```yaml
name: <app.ddev.site>
...
php_version: "8.2"
```

Start the server
```bash
ddev start
ddev ssh
wp core install --url=https://<ddev_site_url> --title=<site_title> --admin_user=<user> --admin_email=<email> --admin_password=<password>
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

# New Option Menu

Example d'intégration

`functions.php` :
```php
function add_soilla_add_options_page(){

    // Generate admin page
    add_menu_page(
        'Soilla Theme Options',
        'Soilla Theme',
        'manage_options',
        'soilla-theme-options',
        'soilla_theme_create_page',
        'dashicons-admin-generic',
        110
    );

    // Generate sub pages
    add_submenu_page('soilla_theme_options', 'Soilla Theme Options', 'General', 'manage_options', 'soilla_theme_options', 'soilla_theme_create_page');

    // Generate Custom Settings
    add_action('admin_init', 'soilla_custom_settings');
};
add_action('admin_menu', 'add_soilla_add_options_page');

function soilla_custom_settings(){
    register_setting('soilla-settings-group', 'soilla_instagram_url', 'sanitize_url');
    register_setting('soilla-settings-group', 'soilla_email','sanitize_email');

    add_settings_section('soilla-details', 'Soilla Details', 'soilla_details', 'soilla-theme-options');

    add_settings_field('soilla_instagram_url', 'Instagram URL', 'soilla_instagram_url', 'soilla-theme-options', 'soilla-details');
    add_settings_field('soilla_email', 'Email', 'soilla_email', 'soilla-theme-options', 'soilla-details');
}

function soilla_details(){
    echo 'Customize your Soilla Theme';
}

function soilla_instagram_url(){
    $soilla_instagram_url = esc_attr(get_option('soilla_instagram_url'));
    echo '<input type="text" name="soilla_instagram_url" value="'.$soilla_instagram_url.'" placeholder="Instagram URL vers le compte Soilla" />';
}

function soilla_email(){
    $soilla_email = esc_attr(get_option('soilla_email'));
    echo '<input type="text" name="soilla_email" value="'.$soilla_email.'" placeholder="Email de contact" />';
}

function soilla_theme_create_page(){
    // generation of our admin page
    require_once(get_template_directory() . '/resources/soilla-templates/soilla-admin.php');
};
```

Et dasn la template
`soilla-admin.php`:
```php
<h1>Soilla Options</h1>
<?php settings_errors();?>
<form action="options.php" method="post">
   <?php
    settings_fields('soilla-settings-group');
    do_settings_sections('soilla-theme-options');
    submit_button('Save Changes', 'primary', 'btnSubmit');
   ?>
</form>
```
