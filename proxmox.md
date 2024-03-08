# Extend a disk

```bash
# 1st step increase resize dik from GUI console
# ou qm resize <vmid> <disk> <size>
# qm resize 100 virtio0 +5G
fdisk -l
gparted /dev/sda
  resizepart 3 100%
  quit
pvresize /dev/sda3
pvdisplay

# extend logical volume
lvdisplay
lvextend -l +100%FREE /dev/ubuntu-vg/ubuntu-lv
lvdisplay

# Resize filesystem
resize2fs /dev/ubuntu-vg/ubuntu-lv
fdisk -l
```

# Unlock Vm

```bash
qm unlock <vmid>
```
