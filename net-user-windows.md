# View users
```bash
net users
net user administrateur
net User /add /domain testusr * /fullname:"Test User" /passwordreq:yes /time:M-F,08:00-17:00 /homedir:"\\lazyadmin.local\home\testusr" /scriptpath:"\\lazyadmin.local\netlogon\welcome.bat"
net user /delete lazyadmin
net user /delete /domain testusr
net user lazyadmin /active:yes
net user <user> <password> /add
net localgroup administrators <user> /add

# set password
net user LazyAdmin passswd123
# password prompt
net user LazyAdmin *
# reset password for the domain
net user /domain testusr *
```

# Computer Management UI

```bash
compmgmt.msc
# Ou bien click droit sur "Mon PC" -> Gestion de l'ordinateur
```
