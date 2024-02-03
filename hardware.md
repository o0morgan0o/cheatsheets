# (slug: view-network-card) View Network Card info

lspci | grep -i eth
lspci -nnk | grep -A2 Ethernet

# (slug: network-segmentation) Network Segmentation

ethtool -k eno1 | grep -i segmentation

# (slug: network-card-settings)

ethtool -K <interface_name> gso off gro off tso off tx off rx off rxvlan off txvlan off sg off