# Commands

```bash
# Verify connection
rsync --dry-run /<source1> [/<source2>] -e ssh user@ip:/<destination>

# simple backup
rsync \
  --archive \
  --recursive \
  --progress \
  --human-readable \
  --exclude=
  --delete  # for delete in destinations files not present in source
  --log-file=/home/morgan/rsync.log \
  --exclude 'sample*' --exclude='*.tmp'
  /tmp \
  -e ssh user@ip:/tmp
```
