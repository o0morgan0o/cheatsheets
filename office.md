# Check license type

```bash
cd c:\Program Files (x86)\Microsoft Office\Office 16\
cd c:\Program Files\Microsoft Office\Office 16\

cscript ospp.vbs /dstatus
```

```bash
Set-ExecutionPolicy RemoteSigned -Scope Process
cd c:\Program Files\Microsoft Office\Office 16\
.\vNextDiag.ps1 -list
```
Will return (User|Subscription) of (Device|Perpetual)

See current subscriptions: https://account.microsoft.com/services
