## Laravel 10 Upgrade

## How to update project

- Update Skeleton with latest release
- Update versions
- Update vendor publishes
- Run migrations/seeders required
- Run tests

### Steps
Copy .env.example to .env and change the DB_CONNECTION to sqlite

Run:
```sh
rm config/sanctum.php
touch database/database.sqlite
composer update
composer remove laravel/sanctum
composer remove laravel/sail
php artisan filament:install --panels
php artisan breeze:install blade
php artisan passport:install --uuids
php artisan telescope:install
php artisan horizon:install
php artisan filament:upgrade
php artisan horizon:publish
php artisan telescope:publish
php artisan queue:batches-table
php artisan queue:failed-table
php artisan queue:table
php artisan notifications:table
php artisan cache:table
php artisan key:generate
php artisan lang:add pt_BR
php artisan lang:add en
```
- Run `php artisan vendor:publish --existing --force` or `php artisan vendor:publish --all --force` to publish all files changed
- Check your changes and revert/update the files
