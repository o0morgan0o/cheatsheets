# View Network Card info

```bash 
lspci | grep -i eth
lspci -nnk | grep -A2 Ethernet
```

# Network Segmentation

```bash
ethtool -k eno1 | grep -i segmentation
```

# Network-card-settings

```bash
ethtool -K <interface_name> gso off gro off tso off tx off rx off rxvlan off txvlan off sg off
```
