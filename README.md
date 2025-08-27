# 🚀 PHP Locator

**Click to Code for PHP** - Instantly jump from your browser to the exact line in your IDE

![PHP Locator Demo](https://user-images.githubusercontent.com/placeholder/demo.gif)

## ✨ What is PHP Locator?

PHP Locator is a browser extension that brings the magic of **click-to-code** to PHP development. Just like [LocatorJS](https://www.locatorjs.com/) for JavaScript frameworks, PHP Locator lets you click on any element in your PHP website and instantly jump to the corresponding source code line in VS Code.

## 🎯 Key Features

- **Zero Configuration** - Works automatically on any PHP page
- **Auto Detection** - No need to modify your PHP code
- **IDE Integration** - Opens exact lines in VS Code with one click
- **Visual Highlighting** - Purple overlay shows clickable elements
- **LocatorJS Compatible** - Same UX you already know and love

## 🚀 Quick Start

### 1. Install Browser Extension

1. Download the `extension` folder
2. Open Chrome and go to `chrome://extensions/`
3. Enable "Developer mode"
4. Click "Load unpacked" and select the `extension` folder

### 2. Setup PHP Auto-Detection

**Option A: Zero-Config Mode (Recommended)**
```php
<?php
// Add this single line to your PHP entry point (index.php, etc.)
require_once 'path/to/phplocator.php';

// That's it! All your HTML elements now have source mapping
?>
<div>This div is now clickable in the browser!</div>
```

**Option B: Manual Mode**
```php
<?php
// For fine-grained control, use data attributes manually
?>
<div data-php-file="<?php echo __FILE__; ?>" data-php-line="<?php echo __LINE__; ?>">
    Manual source mapping
</div>
```

### 3. Start Clicking!

1. Hold **Alt** key
2. Hover over any HTML element (purple highlight appears)
3. Click the element
4. VS Code opens to the exact source line! 🎉

## 📁 Project Structure

```
phplocator/
├── extension/           # Browser extension
│   ├── manifest.json   # Extension configuration
│   ├── content.js      # Main click-to-code logic
│   ├── popup.html      # Extension popup UI
│   └── popup.js        # Popup functionality
├── standalone/         # PHP integration
│   ├── phplocator.php  # Auto-detection class
│   ├── zero-config-demo.php     # Zero-config example
│   └── manual-demo.php          # Manual mapping example
├── demo.php            # Marketing website + live demo
├── index.html          # Static marketing website
└── README.md           # This file
```

## 🔧 Advanced Usage

### PHP Class Usage

```php
<?php
require_once 'phplocator.php';

// Automatic output buffering and source mapping
$locator = new PHPLocator();
$locator->enable();

// Your existing code continues unchanged
?>
<h1>Welcome to my site</h1>
<div class="content">
    <?php echo "Generated content"; ?>
</div>
```

### Custom IDE Configuration

By default, PHP Locator opens files in VS Code. To customize:

```javascript
// In extension/content.js, modify the openInIDE function:
function openInIDE(filePath, lineNumber) {
    // For PHPStorm:
    const url = `phpstorm://open?file=${filePath}&line=${lineNumber}`;
    
    // For Sublime Text:
    const url = `subl://open?url=file://${filePath}&line=${lineNumber}`;
    
    window.open(url, '_self');
}
```

## 🎨 How It Works

1. **PHP Side**: The `PHPLocator` class uses output buffering to capture your HTML and automatically injects `data-php-file` and `data-php-line` attributes by parsing your source code
2. **Browser Side**: The extension detects these attributes and enables click-to-code functionality
3. **IDE Integration**: Clicking generates a `vscode://` URL that opens the exact file and line

## 🌟 Why PHP Locator?

**Before PHP Locator:**
- Inspect element → copy selector → search codebase → find template → scroll to line
- 5+ minutes per element 😴

**After PHP Locator:**
- Hold Alt → Click → Code opens instantly
- 2 seconds per element ⚡️

## 🔥 Live Demo

Visit our demo page to see PHP Locator in action:
- **Live Demo**: [http://localhost:8001/demo.php](http://localhost:8001/demo.php)
- **Marketing Site**: [http://localhost:8001/index.html](http://localhost:8001/index.html)

## 🛠 Development

### Run Local Demo

1. Start PHP development server:
```bash
cd phplocator
php -S localhost:8001
```

2. Visit http://localhost:8001/demo.php
3. Install the browser extension
4. Hold Alt and click any element!

### Extension Development

1. Make changes to `extension/` files
2. Go to `chrome://extensions/`
3. Click reload button for PHP Locator extension
4. Test your changes

## 🤝 Contributing

We welcome contributions! Here's how you can help:

1. **Bug Reports**: Found an issue? [Open an issue](https://github.com/phplocator/phplocator/issues)
2. **Feature Requests**: Have an idea? We'd love to hear it!
3. **Pull Requests**: Code improvements are always welcome
4. **IDE Support**: Help us add support for more IDEs

## 📋 Browser Compatibility

| Browser | Status | Notes |
|---------|--------|-------|
| Chrome | ✅ Full Support | Recommended |
| Firefox | 🔄 Coming Soon | Manifest V2 version planned |
| Safari | 🔄 Planned | WebKit extension in progress |
| Edge | ✅ Full Support | Same as Chrome |

## 🗺 Roadmap

- [ ] **Firefox Extension** - Manifest V2 version
- [ ] **Safari Extension** - WebKit version  
- [ ] **PHPStorm Integration** - Native IDE protocol
- [ ] **Framework Adapters** - Laravel, Symfony, WordPress
- [ ] **Source Maps** - Support for compiled templates
- [ ] **Chrome Web Store** - One-click installation

## 📄 License

MIT License - feel free to use in your projects!

## 🙏 Credits

Inspired by the amazing [LocatorJS](https://www.locatorjs.com/) project. PHP Locator brings the same magical developer experience to the PHP ecosystem.

---

**Made with ❤️ for PHP developers who love efficient debugging**

[⭐ Star on GitHub](https://github.com/zemmelmootez/phplocator) | [🐛 Report Bug](https://github.com/zemmelmootez/phplocator/issues) | [💡 Request Feature](https://github.com/zemmelmootez/phplocator/issues/new)
