# API

Pour voir la requête API originale
`kubectl get pods -v=8`

# Sniffing

Ouvrir un wireshark dans un pod
`kubectl sniff <pod-name> -n <namespace> -p`

# Secrets

Créer un docker registry secret
```bash
kubectl create secret docker-registry <secret-name> --docker-server=<registry-server> --docker-username=<user> --docker-password=<password> --docker-email=<email>
kubectl create secret generic <secret-name> --from-literal=<key>=<value>
```

# ImagePullPolicy

```docker-compose
spec:
  containers:
  - name: myapp
    image: myregistry.com/myapp:5c3dda6b
    ports:
    - containerPort: 80
    imagePullPolicy: Always
  imagePullSecrets:
    - name: myregistry.com-registry-key
```

# Voir les secrets
```bash
kubectl view-secret <secret> -n <namespace> -a
```
