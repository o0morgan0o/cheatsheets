# Commands

```bash
# clear dns cache (debian)
sudo resolvectl flush-caches

# resolution
resolvectl query google.com
resolvectl --type=MX query google.com

# retreive public key
resolvectl opengpg email

# retrieve tls key
resolvectl tlsa tcp domain:443
```
