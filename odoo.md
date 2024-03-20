# Odoo cli

```bash
./odoo-bin -c ./debian/odoo.conf \
  -d odoo \
  -u "all" \
  --workers=0 \
  --no-http \
  --i18n-overwrite \
  --without-demo=WITHOUT_DEMO \
  --stop-after-init
```
