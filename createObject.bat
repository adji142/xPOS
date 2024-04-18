@echo off
REM Check if the number of parameters is correct
if "%~1"=="" (
    echo Usage: %0 param1
    exit /b 1
)

REM Accessing parameters
set param1=%1

REM Displaying parameters
echo Creating Object : %param1%

php artisan make:model %param1%
php artisan make:Controller %param1%Controller
php artisan make:seeder %param1%Seeder
php artisan make:migration %param1%

REM Add more commands as needed