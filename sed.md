# Remove comments in file

```bash
cat /usr/local/etc/php/php.ini | sed -e '/^[ \t]*#/d'
```

## Remove also empty lines

```bash
cat /usr/local/etc/php/php.ini | sed -e '/^[ \t]*#/d' | sed '/^$/d'
```
