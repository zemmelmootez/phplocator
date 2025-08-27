@echo off
echo.
echo =====================================================
echo  🚀 PHP Locator - Installation Script
echo =====================================================
echo.

echo [1/4] Starting PHP development server...
echo.
start /B php -S localhost:8001
timeout /T 3 >nul

echo [2/4] Opening Chrome Extensions page...
echo.
start chrome://extensions/

echo [3/4] Opening demo page...
echo.
timeout /T 2 >nul
start http://localhost:8001/demo.php

echo [4/4] Installation Instructions:
echo.
echo   1. In Chrome Extensions page:
echo      - Enable "Developer mode" (top right)
echo      - Click "Load unpacked"
echo      - Select the "extension" folder from this directory
echo.
echo   2. Test the extension:
echo      - Go to the demo page (should open automatically)
echo      - Hold Alt key and hover over elements
echo      - Click highlighted elements to open in VS Code!
echo.
echo =====================================================
echo  ✅ Setup complete! Happy debugging!
echo =====================================================
echo.
echo Press any key to stop the PHP server...
pause >nul

echo.
echo Stopping PHP server...
taskkill /F /IM php.exe >nul 2>&1
echo Server stopped. Goodbye!
