# ESLint Configuration

```bash
npm init @eslint/config
npx eslint --init

npx eslint . --ext .ts,.tsx --fix
```

# Remove specific rules


```yaml
# .eslintrc.yml
env:
  browser: true
  es2021: true
extends:
  - eslint:recommended
  - plugin:@typescript-eslint/recommended
  - plugin:react/recommended
parser: '@typescript-eslint/parser'
parserOptions:
  ecmaVersion: latest
  sourceType: module
plugins:
  - '@typescript-eslint'
  - react
rules: {
  '@typescript-eslint/no-unused-vars': 'off',
  'prefer-const':'off',
  '@typescript-eslint/no-explicit-any':'off',
}

```
