# New Project
```bash
symfony new my-app
cd my-app
composer require webapp
```

# Commands

```bash
bin/console doctrine:query:sql "SELECT \* FROM user"

bin/console debug:container --env-vars
bin/console debug:container --parameters
bin/console debug:router
bin/console debug:router <my_route>
bin/console debug:router <my_route> --show-aliases
bin/console router:match /my-route

bin/console debug:dotenv
bin/console security:hash-password
bin/console make:registration-form
bin/console var:export --multiline
bin/console doctrine:database:create --env=test
bin/console doctrine:schema:create --env=test

bin/console debug:autowiring


bin/phpunit --testdox

symfony new --full my_project
symfony open:local:webmail // composer require symfony/mailer
symfony local:php:list  ## voir les versions de php disponibles

composer require symfony/mailer
composer require zenstruct/mailer-test --dev
```

# Doctrine
```bash
DATABASE_URL="postgresql://user:password@host:5432/app" php bin/console doctrine:migrations:migrate
```

# Symfony App with React
```bash
composer require asset-mapper asset twig
composer require maker-bundle --dev
composer require dtof/doctrine-extensions-bundle
bin/console debug:asset-map
```

# Stimulus From Scratch
```bash
symfony new app
composer require twig-bundle
compose require maker-bundle --dev
composer require symfony/webpack-encore-bundle
bin/console make:controller HomeController
composer require symfony/stimulus-bundle
npm install
npm run watch
```

`assets/app.js`:
```js
import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
```

`assets/bootstrap.js`
```js
import { startStimulusApp } from '@symfony/stimulus-bridge';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
```

`templates/home/index.html.twig`
```twig
...
<div class="example-wrapper">
    <h1>Hello {{ controller_name }}! ✅</h1>
    This friendly message is coming from:
    <div {{  stimulus_controller('hello') }}></div>
</div>
```
