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

# Basic View in Module

Note: Don't forget to add permissions in `security/ir.model.access.csv` and import the security file in `data` in `manifest.json`.

```xml
<!-- suppose a model hospital.patient -->
<?xml version="1.0" encoding="UTF-8" ?>
<odoo>
  <data>

    <!-- Custom view for this model -->
    <record id="om_hospital.patient_form_view" model="ir.ui.view">
      <field name="name">hospital.patient.form</field>
      <field name="model">hospital.patient</field>
      <field name="arch" type="xml">
        <form string="Patient">
          <sheet>
            <group>
              <field name="name"/>
              <field name="age"/>
              <field name="lastName"/>
            </group>
          </sheet>
        </form>
      </field>
    </record>

    <!-- Default view for this model -->
    <record model="ir.actions.act_window" id="om_hospital.show">
      <field name="name">Patient</field>
      <field name="res_model">hospital.patient</field>
      <field name="view_mode">tree,form</field>
      <!--      <field name="view_id" ref="om_hospital.patient_form_view"/>-->
      <field name="help" type="html">
        <p class="o_view_nocontent_smiling_face">
          Create the first patient
        </p>
      </field>
    </record>

    <menuitem id="menu_hospital_root" name="Hospital" sequence="0" action="om_hospital.show"/>

  </data>
</odoo>
```
