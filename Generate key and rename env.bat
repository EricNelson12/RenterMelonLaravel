
mode con: cols=110 lines=10
@echo off
ren .env.example .env
php artisan key:generate

echo Happy Meloning!!!

pause