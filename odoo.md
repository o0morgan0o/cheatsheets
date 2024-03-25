# Odoo cli

Create custom-module 

```bash
./odoo-bin scaffold odoo_controller ./custom-addons
```

```bash
./odoo-bin \
  --config ./debian/odoo.conf \
  --database odoo \
  --update "all" \
  --workers=0 \
  --no-http \
  --i18n-overwrite \
  --without-demo=WITHOUT_DEMO \
  --stop-after-init
  --init crm
```

For automatic reload with `watchdog`:

```bash
watchmedo auto-restart \ 
  -d ./custom-addons \
  --patterns="*.*" \
  --recursive \
  --signal=SIGKILL \
  --debounce-interval=0.3 \
  ./odoo-bin \
  -- -c ./debian/odoo.conf -d test-2 --dev all -u real_estate_ads
```

Minimal `odoo.conf` file is : 

```toml
[options]
admin_passwd = mysupersecretpassword
db_host = 127.0.0.1
db_port = 5432
db_user = odoo
db_password = odoo
dbfilter = ^mycompany.*$
```
