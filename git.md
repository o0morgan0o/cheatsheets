# (slug: origin) Origin

git remote remove origin
git remote add origin <origin>
git remote show origin

# (slug: several-remotes) Several Remotes

Register the remote as push url (to do on both urls)
git remote set-url --add --push origin <remote-url-1>
git remote set-url --add --push origin <remote-url-2>
git remote -v

# (slug: config) Config

git config --list
git config --edit
git config --global --user.name "John Doe"
git config --global --user.email "john.doe@mail.com"
git config --global --edit
vim ~/.gitconfig

# (slug: github-pat-token)
```
git remote set-url origin https://<user>:<token_pat>@github.com/<username>/<repo>.git
```
