# Cli-Connections
```bash
openssl s_client -crlf -connect imap.gmail.com:993
tag login <user>@gmail.com <password>
tag LIST "" "*"  # list mailboxes
tag SELECT INBOX
tag STATUS INBOX (MESSAGES)
tag LOGOUT
```
