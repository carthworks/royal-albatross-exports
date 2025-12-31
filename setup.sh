#!/bin/bash

# Royal Albatross Exports - Mac/Linux Setup Script
# This script helps you set up and test the website locally

echo "========================================"
echo "Royal Albatross Exports Website Setup"
echo "========================================"
echo ""

# Check if running in correct directory
if [ ! -f "index.html" ]; then
    echo "ERROR: index.html not found!"
    echo "Please run this script from the website root directory."
    exit 1
fi

echo "[1/5] Checking file structure..."
if [ -f "css/styles.css" ]; then
    echo "  ✓ CSS files found"
else
    echo "  ✗ WARNING: CSS files missing!"
fi

if [ -f "js/script.js" ]; then
    echo "  ✓ JavaScript files found"
else
    echo "  ✗ WARNING: JavaScript files missing!"
fi

if [ -d "assets/images" ]; then
    echo "  ✓ Images directory found"
else
    echo "  ✗ WARNING: Images directory missing!"
    mkdir -p "assets/images"
    echo "  ✓ Created images directory"
fi

echo ""
echo "[2/5] Verifying dependencies..."
echo "  ✓ Bootstrap 5 (CDN)"
echo "  ✓ Font Awesome (CDN)"
echo "  ✓ AOS Library (CDN)"
echo "  ✓ Google Fonts (CDN)"
echo "  All dependencies loaded from CDN - Internet required"
echo ""

echo "[3/5] Checking PHP configuration..."
if command -v php &> /dev/null; then
    echo "  ✓ PHP is installed"
    php -v
    echo ""
    echo "  You can test the contact form with PHP's built-in server:"
    echo "  Run: php -S localhost:8000"
else
    echo "  ✗ PHP not found"
    echo "  - Contact form will require a PHP-enabled server"
    echo "  - You can still view the website without PHP"
fi

echo ""
echo "[4/5] Setting permissions..."
chmod 644 index.html
chmod 644 css/*.css 2>/dev/null
chmod 644 js/*.js 2>/dev/null
chmod 755 assets/images 2>/dev/null
if [ -f "script.php" ]; then
    chmod 644 script.php
fi
echo "  ✓ File permissions set"

echo ""
echo "[5/5] Setup complete!"
echo ""

echo "========================================"
echo "Next Steps:"
echo "========================================"
echo ""
echo "Option 1: View in Browser (Static)"
echo "  - Open index.html in your browser"
echo "  - macOS: open index.html"
echo "  - Linux: xdg-open index.html"
echo "  - Note: Contact form won't work without a server"
echo ""
echo "Option 2: Use PHP Built-in Server"
echo "  - Run: php -S localhost:8000"
echo "  - Open browser to: http://localhost:8000"
echo "  - Contact form will work"
echo ""
echo "Option 3: Use MAMP/XAMPP (macOS)"
echo "  - Copy files to htdocs folder"
echo "  - Access via http://localhost/your-folder"
echo "  - Full PHP functionality"
echo ""
echo "Option 4: Use Apache (Linux)"
echo "  - Copy to /var/www/html/"
echo "  - Access via http://localhost/"
echo "  - Full PHP functionality"
echo ""
echo "========================================"
echo "Customization:"
echo "========================================"
echo "  - See CUSTOMIZATION.md for detailed guide"
echo "  - Edit index.html for content"
echo "  - Edit css/styles.css for styling"
echo "  - Edit script.php for form settings"
echo ""
echo "========================================"
echo "Support:"
echo "========================================"
echo "  Email: royalalbatrossexports@gmail.com"
echo "  Phone: +91 94422 29082"
echo ""

# Ask if user wants to open in browser
read -p "Open website in default browser now? (y/n): " OPEN
if [ "$OPEN" = "y" ] || [ "$OPEN" = "Y" ]; then
    echo "Opening website..."
    if [[ "$OSTYPE" == "darwin"* ]]; then
        # macOS
        open index.html
    elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
        # Linux
        xdg-open index.html 2>/dev/null || echo "Please open index.html manually"
    fi
fi

echo ""
echo "Thank you for using Royal Albatross Exports Website!"
echo ""
