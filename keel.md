# Kubernetes annnotations 

Example :

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: my-app
  namespace: my-app
  annotations:
    keel.sh/policy: force
    keel.sh/trigger: poll
    keel.sh/pollSchedule: "@every 5m"
```
