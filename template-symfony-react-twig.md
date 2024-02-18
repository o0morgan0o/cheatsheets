# (slug: install-template)
```
symfony new my-app
cd my-app
composer install
composer require twig
composer require --dev maker-bundle
bin/console make:controller # HomeController
composer require pentatrion/vite-bundle # y
npm i
composer require symfony/stimulus-bundle
npm rm @symfony/stimulus-bridge
composer require symfony/ux-react
npm i 
npm i @vitejs/plugin-react
npm run dev
```

```
// assets/bootstrap.js
import { startStimulusApp, registerControllers } from "vite-plugin-symfony/stimulus/helpers" 
import { registerReactControllerComponents } from "vite-plugin-symfony/stimulus/helpers/react" 
registerReactControllerComponents(import.meta.glob('./react/controllers/**/*.[jt]s(x)\?')); 

const app = startStimulusApp();
registerControllers(app, import.meta.glob('./controllers/*_(lazy)\?controller.[jt]s(x)\?'))
```

```
// vite.config.js
import { defineConfig } from 'vite'

import symfonyPlugin from 'vite-plugin-symfony';
import reactPlugin from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    reactPlugin(), 
    symfonyPlugin({
      stimulus: true 
    }),
  ],
  build: {
    rollupOptions: {
      input: {
        "app": "./assets/app.ts",
      }
    },
  },
});
```

```
{# base.html.twig #}
{{ vite_entry_link_tags('app') }}
{{ vite_entry_script_tags('app', {
    dependency: 'react' 
  }) }}
```

```
{# your-template.html.twig #}
<div {{ react_component('Hello', { 'fullName': 'Vite & Stimulus' }) }}></div>
```

```
// assets/react/controllers/Hello.tsx
import React from 'react';

export default function (props) {
    return <div>Hello {props.fullName}</div>;
}
```

```
// tsconfig.json
{
  "compilerOptions": {
    "jsx": "react",
    "target": "es2016",
    "module": "commonjs",
    "esModuleInterop": true,
    "forceConsistentCasingInFileNames": true,
    "strict": true,
    "skipLibCheck": true
  }
}
```
