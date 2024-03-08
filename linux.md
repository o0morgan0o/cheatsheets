# Open init shells

```bash
Ctrl + Alt + F<1-7>
```


# Chroot for recovery (boot from live-cd)

```bash
sudo mount --bind /dev /path/to/chroot/environment/dev
sudo chroot /media/user/<disk> bin/bash
```
