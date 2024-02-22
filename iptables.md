# iptables for Kubernetes

```bash
iptables --numeric --table nat --list KUBE-SERVICES
iptables -n -t nat -L KUBE-SERVICES
iptables -n -t nat -L KUBE-SVC-QJKJRXOIRIJKE68234JK
iptables -n -t nat -L KUBE-SEP-IOWEJKJKMVOWEKRJKJ43
```
