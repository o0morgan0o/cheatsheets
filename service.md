# Config Example

```toml
Example after systemctl --user edit --force --full my-service.service
[Unit]
Description=My Unit
[Service]
ExecStart=/bin/my-binary
[Install]
WantedBy=default.target
```

# Timer Example

```toml
after systemctl --user edit --force --full my-service.timer
[Unit]
Description=My Service Timer
[Timer]
OnBootSec=10min
OnUnitActiveSec=30min
[Install]
WantedBy=timers.target
```
