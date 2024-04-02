# Commandes

```bash
# save output
curl http://example.com/file.zip -o new_file.zip

# POST form
curl -F "name=user" -F "password=test" http://example.com
# POST json
curl -H "Content-Type: application/json" -X POST -d '{"user":"bob","pass":"123"}' http://example.com

# Manual resolve
curl http://example.com --resolve example.com:80:127.0.0.1
curl http://www.example.com --resolve www.example.com:80:127.0.0.1 --resolve www.example.com:443:127.0.0.1
```
