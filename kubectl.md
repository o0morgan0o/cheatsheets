# (slug: api) API

Pour voir la requête API originale
`kubectl get pods -v=8`

# (slug: sniffing) Sniffing

Ouvrir un wireshark dans un pod
`kubectl sniff <pod-name> -n <namespace> -p`

# (slug: secrets) Secrets

Créer un docker registry secret
`kubectl create secret docker-registry <secret-name> --docker-server=<registry-server> --docker-username=<user> --docker-password=<password> --docker-email=<email>`
`kubectl create secret generic <secret-name> --from-literal=<key>=<value>`

# (slug: imagepullpolicy) ImagePullPolicy

`spec:`
`  containers:`
`  - name: myapp`
`    image: myregistry.com/myapp:5c3dda6b`
`    ports:`
`    - containerPort: 80`
`    imagePullPolicy: Always`
`  imagePullSecrets:`
`    - name: myregistry.com-registry-key`