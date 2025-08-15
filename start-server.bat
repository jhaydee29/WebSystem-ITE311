@echo off
:: Kill any PHP processes
taskkill /F /IM php.exe >nul 2>&1

:: Start PHP server explicitly on port 8000
php -S localhost:8000 -t public

:: Open browser automatically
start http://localhost:8000

pause
