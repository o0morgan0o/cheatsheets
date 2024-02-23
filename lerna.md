# Run Commands on all packages
```bash
npx lerna run build

# concurrent tasks
npx lerna run test,build,lint

# task for a single package
npx lerna run test --scope=header
```
