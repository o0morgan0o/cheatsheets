# (slug: commands) Commands

```
bin/console doctrine:query:sql "SELECT \* FROM user"

bin/console debug:container --env-vars
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

bin/phpunit --testdox

symfony new --full my_project
symfony open:local:webmail // composer require symfony/mailer

composer require symfony/mailer
composer require zenstruct/mailer-test --dev
```
