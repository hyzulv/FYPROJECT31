@echo off
REM Sync database and push to Git

echo Syncing database...
cd /d "%~dp0"
php artisan db:sync

if %errorlevel% neq 0 (
    echo Database sync failed.
    pause
    exit /b 1
)

echo Database synced. Pushing to Git...
git push

if %errorlevel% neq 0 (
    echo Git push failed.
    pause
    exit /b 1
)

echo Done! Database synced and pushed successfully.
pause
