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

# Xmlrpc

Basic connection : 

```python
import xmlrpc.client

url = 'http://127.0.0.1:8069'
db = '<db>'
username = '<user>'
password = '<password>'

# info = xmlrpc.client.ServerProxy(url).start()
# 
# url, db, username, password = info['host'], info['database'], info['user'], info['password']

common = xmlrpc.client.ServerProxy('{}/xmlrpc/2/common'.format(url))
ver = common.version()
print(ver)
uid = common.authenticate(db, username, password, {})
print(uid)

models = xmlrpc.client.ServerProxy('{}/xmlrpc/2/object'.format(url))
canRead = models.execute_kw(db, uid, password, 'res.partner', 'check_access_rights', ['read'], {'raise_exception': False})
print("canRead", canRead)

response = models.execute_kw(db, uid, password, 'res.partner',
                             'search_read',
                             [[['is_company', '=', True]]],
                             {'fields': ['name', 'phone'], 'limit': 5})
print(response)

# get all fields in model
response = models.execute_kw(db, uid, password, 'estate.property', 'search_read', [[]],
                             {'fields': ['name'], 'limit': 0})
print(response)
```
