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

# Tests

```bash
go test -fuzz=FuzzReverse
go test -fuzztime 10s
# Execute fuzz with random data
go test -fuzz=Fuzz

# Run only failing test (get the hash in original test)
go test -run=FuzzReverse/deaae2ca3cf382f4
```

```go
func TestReverse(t *testing.T) {
	testcases := []struct {
		in, want string
	}{
		{" ", " "},
		{"!12345", "54321!"},
	}

	for _, tc := range testcases {
		rev := Reverse(tc.in)
		if rev != tc.want {
			t.Errorf("Reverse(%q) = %q; want %q", tc.in, rev, tc.want)
		}
	}
}

func FuzzReverse(f *testing.F) {
	testcases := []string{"Hello, world", " ", "!12345"}
	for _, tc := range testcases {
		f.Add(tc)
	}

	f.Fuzz(func(t *testing.T, orig string) {
		rev := Reverse(orig)
		doubleRev := Reverse(rev)
		if orig != doubleRev {
			t.Errorf("Reverse(%q) = %q; want %q", orig, doubleRev, orig)
		}
		if utf8.ValidString(orig) && !utf8.ValidString(rev) {
			t.Errorf("Reverse(%q) = %q; invalid UTF-8", orig, rev)
		}
	})
}
```
