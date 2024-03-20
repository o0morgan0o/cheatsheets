# Activation

```bash
nmcli radio wifi on
nmcli device wifi list
nmcli device connect <ssid> --ask
nmcli connection modify <ssid> ipv4.method manual ipv4.addresses 192.0.2.1/24 ipv4.gateway 192.0.2.254 ipv4.dns 192.0.2.200 ipv4.dns-search example.com
nmcli connection modify <ssid> ipv6.method manual ipv6.addresses 2001:db8:1::1/64 ipv6.gateway 2001:db8:1::fffe ipv6.dns 2001:db8:1::ffbb ipv6.dns-search example.com
nmcli connection up <ssid>

nmcli connection show --active
```
