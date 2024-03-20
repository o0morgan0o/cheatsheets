# NixOs first steps

```bash
nmcli radio wifi on
nmcli device wifi list
nmcli device connect <ssid> --ask

cd /etc/nixos/
sudoedit configuration.nix

sudo nixos-rebuild switch

cd /tmp
git clone git@github.com:o0morgan0o/nixos.git
cp /tmp/nixos/configuration.nix /etc/nixos/configuration.nix

sudo nixos-rebuild switch --flake github:owner/repo
```

You can regenerate blank config with `nixos-generate-config --force`.
