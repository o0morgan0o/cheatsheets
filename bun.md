# QuickStart

```bash
bun init
bun run --watch index.ts
bun run --env-file=.env.local index.ts

bun install react
bun install @biomejs/biome --dev
bun install
bun build ./index.ts --outdir ./out --watch

# debugger
bun --inspect server.ts
bun --inspect-wait server.ts
bun --inspect=localhost:4000 server.ts

# compile for production
bun build --compile --minify --sourcemap app.ts --outfile app

# equivalent for create project with node
bun create vite

# run script
bun run start
bun run dev

# run executable from npm
bunx cowsay "Hello world"

```

# Create binary

```bash
bun build ./cli.ts --compile --outfile mycli
```

# Usage with sqlite

```ts
import db from "./my.db" with {type: "sqlite"};
console.log(db.query("select * from users LIMIT 1").get());
```

# Import.meta

```ts
import.meta.dir;   // => "/path/to/project"
import.meta.file;  // => "file.ts"
import.meta.path;  // => "/path/to/project/file.ts"

import.meta.main;  // `true` if this file is directly executed by `bun run`
                   // `false` otherwise

import.meta.resolveSync("zod")
// resolve an import specifier relative to the directory
```
