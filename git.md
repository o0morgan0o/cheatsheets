# Example Gitlab & Github Repo (Pull from gitlab)

```toml
# .git/config
[core]
  repositoryformatversion = 0
  filemode = true
  bare = false
  logallrefupdates = true
[remote "origin"]
  pushurl = git@github.com:<user>/<repo>.git
  fetch = +refs/heads/*:refs/remotes/origin/*
  gh-resolved = base
  pushurl = git@<gitlab_url>:<user>/<repo>.git
[branch "main"]
  remote = origin
  merge = refs/heads/main
[pull]
  rebase = false
```


# Origin

```bash
git remote remove origin
git remote add origin <origin>
git remote show origin
```

# Several Remotes

Register the remote as push url (to do on both urls)
```bash
git remote set-url --add --push origin <remote-url-1>
git remote set-url --add --push origin <remote-url-2>
git remote -v
```

# Config

```bash 
git config --list
git config --edit
git config --global --user.name "John Doe"
git config --global --user.email "john.doe@mail.com"
git config --global --edit
vim ~/.gitconfig
```

# Github pat token
```bash
git remote set-url origin https://<user>:<token_pat>@github.com/<username>/<repo>.git
```


