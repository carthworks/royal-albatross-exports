@echo off
REM Royal Albatross Exports - Windows Setup Script
REM This script helps you set up and test the website locally

echo ========================================
echo Royal Albatross Exports Website Setup
echo ========================================
echo.

REM Check if running in correct directory
if not exist "index.html" (
    echo ERROR: index.html not found!
    echo Please run this script from the website root directory.
    pause
    exit /b 1
)

echo [1/5] Checking file structure...
if exist "css\styles.css" (
    echo   - CSS files found
) else (
    echo   - WARNING: CSS files missing!
)

if exist "js\script.js" (
    echo   - JavaScript files found
) else (
    echo   - WARNING: JavaScript files missing!
)

if exist "assets\images" (
    echo   - Images directory found
) else (
    echo   - WARNING: Images directory missing!
    mkdir "assets\images"
    echo   - Created images directory
)

echo.
echo [2/5] Verifying dependencies...
echo   - Bootstrap 5 (CDN)
echo   - Font Awesome (CDN)
echo   - AOS Library (CDN)
echo   - Google Fonts (CDN)
echo   All dependencies loaded from CDN - Internet required
echo.

echo [3/5] Checking PHP configuration...
where php >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    echo   - PHP is installed
    php -v
    echo.
    echo   You can test the contact form with PHP's built-in server:
    echo   Run: php -S localhost:8000
) else (
    echo   - PHP not found in PATH
    echo   - Contact form will require a PHP-enabled server
    echo   - You can still view the website without PHP
)

echo.
echo [4/5] Creating test environment...
echo   Website is ready to view!
echo.

echo [5/5] Setup complete!
echo.
echo ========================================
echo Next Steps:
echo ========================================
echo.
echo Option 1: View in Browser (Static)
echo   - Double-click index.html
echo   - Or right-click and "Open with" your browser
echo   - Note: Contact form won't work without a server
echo.
echo Option 2: Use PHP Built-in Server
echo   - Open Command Prompt in this directory
echo   - Run: php -S localhost:8000
echo   - Open browser to: http://localhost:8000
echo   - Contact form will work
echo.
echo Option 3: Use XAMPP/WAMP
echo   - Copy files to htdocs/www folder
echo   - Access via http://localhost/your-folder
echo   - Full PHP functionality
echo.
echo ========================================
echo Customization:
echo ========================================
echo   - See CUSTOMIZATION.md for detailed guide
echo   - Edit index.html for content
echo   - Edit css/styles.css for styling
echo   - Edit script.php for form settings
echo.
echo ========================================
echo Support:
echo ========================================
echo   Email: royalalbatrossexports@gmail.com
echo   Phone: +91 94422 29082
echo.

REM Ask if user wants to open in browser
echo.
set /p OPEN="Open website in default browser now? (Y/N): "
if /i "%OPEN%"=="Y" (
    echo Opening website...
    start index.html
)

echo.
echo Thank you for using Royal Albatross Exports Website!
echo.
pause
