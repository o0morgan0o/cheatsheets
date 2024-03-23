# Odoo cli

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
