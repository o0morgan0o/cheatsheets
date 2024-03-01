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

# Symfony App with React
```bash
composer require asset-mapper asset twig
composer require maker-bundle --dev
composer require dtof/doctrine-extensions-bundle
bin/console debug:asset-map
```
