
<h1>Start PHP server (instead of Xampp or Wamp)</h1>
php artisan serve

<h1>If cipher related error</h1>
mv .env.example .env
php artisan key:generate

<h1>If DB Credentials are wrong</h1>
Update credentials in .env

<h1>if your db creds aren't showing up right</h1>
php artisan cache:clear
delete contents of storage/framework/views

<h1>If something's missing</h1>
composer install
