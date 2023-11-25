bin/console doctrine:query:sql "SELECT \* FROM user"
bin/console debug:container --env-vars
bin/console debug:router
bin/console debug:dotenv
bin/console security:hash-password
bin/console make:registration-form
