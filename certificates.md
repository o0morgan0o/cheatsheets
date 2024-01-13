# (slug: ca-install) Installation root certificate

on debian
`cp rootCA.crt /usr/local/share/ca-certificates/`
`sudo update-ca-certificates`
remove certificates
`sudo update-ca-certificates --fresh`