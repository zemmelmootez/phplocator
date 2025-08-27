#!/bin/bash

echo ""
echo "====================================================="
echo "  🚀 PHP Locator - Installation Script"
echo "====================================================="
echo ""

echo "[1/4] Starting PHP development server..."
echo ""
php -S localhost:8001 &
SERVER_PID=$!
sleep 3

echo "[2/4] Opening browser pages..."
echo ""

# Try to open Chrome extensions page
if command -v google-chrome >/dev/null 2>&1; then
    google-chrome chrome://extensions/ >/dev/null 2>&1 &
elif command -v chromium >/dev/null 2>&1; then
    chromium chrome://extensions/ >/dev/null 2>&1 &
elif command -v chromium-browser >/dev/null 2>&1; then
    chromium-browser chrome://extensions/ >/dev/null 2>&1 &
else
    echo "Please open Chrome and navigate to: chrome://extensions/"
fi

sleep 2

# Open demo page
if command -v google-chrome >/dev/null 2>&1; then
    google-chrome http://localhost:8001/demo.php >/dev/null 2>&1 &
elif command -v chromium >/dev/null 2>&1; then
    chromium http://localhost:8001/demo.php >/dev/null 2>&1 &
elif command -v chromium-browser >/dev/null 2>&1; then
    chromium-browser http://localhost:8001/demo.php >/dev/null 2>&1 &
else
    echo "Please open your browser and navigate to: http://localhost:8001/demo.php"
fi

echo "[3/4] Installation Instructions:"
echo ""
echo "   1. In Chrome Extensions page:"
echo "      - Enable \"Developer mode\" (top right)"
echo "      - Click \"Load unpacked\""
echo "      - Select the \"extension\" folder from this directory"
echo ""
echo "   2. Test the extension:"
echo "      - Go to the demo page (should open automatically)"
echo "      - Hold Alt key and hover over elements"
echo "      - Click highlighted elements to open in VS Code!"
echo ""

echo "[4/4] ✅ Setup complete! Happy debugging!"
echo ""
echo "====================================================="
echo ""
echo "Press Ctrl+C to stop the PHP server and exit..."

# Wait for interrupt
trap "echo ''; echo 'Stopping PHP server...'; kill $SERVER_PID 2>/dev/null; echo 'Server stopped. Goodbye!'; exit 0" INT

# Keep script running
while true; do
    sleep 1
done
