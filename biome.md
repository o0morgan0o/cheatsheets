# Basic config with tailwind sorting

```bash
npm i -D @biomejs/biome
npx @biomejs/biome init
```

Basic configuration with tailwind sorting `biome.json` :

```json
{
	"$schema": "https://biomejs.dev/schemas/1.6.1/schema.json",
	"organizeImports": {
		"enabled": true
	},
	"linter": {
		"enabled": true,
		"rules": {
			"recommended": true,
			"nursery": {
				"useSortedClasses": "warn"
			}
		}
	}
}
```
