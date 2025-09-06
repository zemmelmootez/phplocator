# PHP Locator - Click to Code

<div align="center">
  <h3>Instantly jump from browser elements to your PHP source code</h3>
  
  [![Packagist Version](https://img.shields.io/packagist/v/zemmelmootez/phplocator?style=flat-square)](https://packagist.org/packages/zemmelmootez/phplocator)
  [![GitHub Stars](https://img.shields.io/github/stars/zemmelmootez/phplocator?style=flat-square)](https://github.com/zemmelmootez/phplocator)
  [![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)
  [![Downloads](https://img.shields.io/packagist/dt/zemmelmootez/phplocator?style=flat-square)](https://packagist.org/packages/zemmelmootez/phplocator)
  
  🌐 **[Live Website & Demo](https://phplocator-hbfl72dni-zemmelmootezs-projects.vercel.app)**
</div>

---

## What is PHP Locator?

PHP Locator brings **click-to-code** functionality to PHP development. Inspired by [LocatorJS](https://www.locatorjs.com/), it allows you to **Alt+Click** any element in your browser and instantly jump to the exact source code line in VS Code.

### Key Benefits:
- **Zero Configuration** - Install and it works automatically
- **Universal Compatibility** - Works with any PHP project or framework
- **Instant Navigation** - Jump directly to source code in seconds
- **Visual Feedback** - Clear indicators show clickable elements
- **Professional Workflow** - Streamlines debugging and development

---

## Installation

### Step 1: Browser Extension

**Chrome/Edge/Brave/Opera:**
- [🚀 Install from Chrome Web Store](https://chrome.google.com/webstore/detail/php-locator/bnhcmehnfejdabgfjlpndjpahkjfhchb) ✅ **NOW LIVE!**

**Manual Installation:**
1. Download the [latest release](https://github.com/zemmelmootez/phplocator/releases)
2. Extract the ZIP file
3. Open `chrome://extensions/`
4. Enable **"Developer mode"**
5. Click **"Load unpacked"** → Select the `extension` folder

### Step 2: PHP Package

#### Option A: Composer (Recommended)

```bash
composer require zemmelmootez/phplocator
```

The package auto-loads and starts working immediately - no additional setup required.

#### Option B: Manual Installation

```bash
git clone https://github.com/zemmelmootez/phplocator.git
```

```php
<?php
require_once 'path/to/phplocator.php';
// Now ready to use
?>
```

---

## Usage

### The Simple Process:

1. **Hold `Alt` key**
2. **Hover over any HTML element** (highlights appear)
3. **Click the element** → VS Code opens to the exact line

### Framework Examples:

**Vanilla PHP:**
```php
<?php
// Composer auto-loads PHP Locator
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Welcome</h1> <!-- Alt+Click opens this line in VS Code -->
    <p>Content here</p>
</body>
</html>
```

**Laravel Blade:**
```php
@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>{{ $title }}</h1> {{-- Alt+Click opens this Blade file --}}
    </div>
@endsection
```

**WordPress:**
```php
<?php
// In your theme's functions.php - Composer auto-loads
?>
<div class="post-content">
    <h2><?php the_title(); ?></h2> <!-- Alt+Click opens this template -->
</div>
```

---

## Advanced Configuration

### Manual Data Attributes
For custom implementations:

```php
<div data-php-file="<?php echo __FILE__; ?>" data-php-line="<?php echo __LINE__; ?>">
    Custom tracked element
</div>
```

### Troubleshooting

**Extension not working?**
- ✅ Extension installed and enabled
- ✅ Developer mode enabled in browser
- ✅ VS Code installed with URL handler
- ✅ PHP package installed via Composer

**No highlights appearing?**
- Check HTML source for: `<!-- PHP Locator: Tracking file: ... -->`
- Verify Composer autoload is working
- Check browser console for errors

**VS Code not opening?**
- Ensure VS Code is properly installed
- Try: `code --install-extension` to register URL handler
- Test with different browsers

---

## Technical Details

### How It Works:
1. PHP Locator automatically injects source mapping data attributes
2. Browser extension detects these attributes
3. Alt+Click triggers VS Code protocol handler
4. VS Code opens the exact file and line number

### Supported Environments:
- **PHP**: 7.4+ (tested with 8.0, 8.1, 8.2, 8.3)
- **Frameworks**: Laravel, Symfony, WordPress, CodeIgniter, or any PHP project
- **Browsers**: Chrome, Edge, Brave, Opera (Firefox coming soon)
- **IDEs**: VS Code (PHPStorm support planned)

---

## Contributing

We welcome contributions! Here's how to help:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/improvement`)
3. Commit your changes (`git commit -m 'Add improvement'`)
4. Push to the branch (`git push origin feature/improvement`)
5. Open a Pull Request

### Development Setup:
```bash
git clone https://github.com/zemmelmootez/phplocator.git
cd phplocator
# Extension development in /extension folder
# PHP development in root directory
```

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Links

- **📦 Package**: [Packagist](https://packagist.org/packages/zemmelmootez/phplocator)
- **🐙 Source**: [GitHub](https://github.com/zemmelmootez/phplocator)
- **🐛 Issues**: [Bug Reports](https://github.com/zemmelmootez/phplocator/issues)
- **💬 Discussions**: [GitHub Discussions](https://github.com/zemmelmootez/phplocator/discussions)

---

<div align="center">
  <strong>⭐ Star this repo if PHP Locator improves your workflow!</strong>
</div>
