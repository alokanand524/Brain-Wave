@echo off
echo ========================================
echo Brain-Wave PostgreSQL Setup
echo ========================================

echo.
echo Step 1: Installing Composer dependencies...
composer install

echo.
echo Step 2: Generating application key...
php artisan key:generate

echo.
echo Step 3: Creating PostgreSQL database...
echo Please make sure PostgreSQL is running and create database 'brainwave'
echo Run this command in PostgreSQL: CREATE DATABASE brainwave;
pause

echo.
echo Step 4: Running migrations...
php artisan migrate

echo.
echo Step 5: Setup complete!
echo Update your .env file with correct PostgreSQL credentials
echo Then run: php artisan serve

pause