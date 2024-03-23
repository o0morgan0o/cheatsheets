# Virtual environment

```bash
# creation
python -m venv venv

# activation
venv\Scripts\activate # for windows
source venv/bin/activate

pip list
pip --version # show if running in venv
pip install pandas
deactivate

# deletion venv
rm -rf <folder>/venv
```

# Use specific python version

Use `pyenv` for this.

```bash
pyenv install --list
pyenv local 3.10.0
```
