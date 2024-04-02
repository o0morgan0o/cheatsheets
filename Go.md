# Commandes

```bash
go mod init example/hello
go mod tidy
go get golang.org/x/example/hello/reverse
go run .
go test -v
go build

# show go install path
go env -w GOBIN=/path/to/your/bin
go list -f '{{.Target}}'
go install

go work init ./hello
go work use ./example/hello

```
