<?php require_once 'standalone/phplocator.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Locator - Click to Code for PHP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #ffffff;
        }
        
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 100px 20px;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .logo {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .tagline {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            max-width: 600px;
            opacity: 0.95;
        }
        
        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            max-width: 700px;
            opacity: 0.9;
        }
        
        .cta-section {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 3rem;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #ff6b6b;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .demo-hint {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-top: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section {
            padding: 80px 20px;
        }
        
        .section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }
        
        .features {
            background: #f8f9fa;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }
        
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .logo { font-size: 2.5rem; }
            .tagline { font-size: 1.2rem; }
            .hero-description { font-size: 1rem; }
            .cta-section { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="logo">🚀 PHP Locator</div>
        <div class="tagline">Click on a component to go to its code</div>
        <div class="hero-description">
            Click on any component in your PHP application to open its code in your IDE.<br>
            Just like LocatorJS, but for PHP. Zero configuration required!
        </div>
        
        <div class="cta-section">
            <a href="#extension" class="btn btn-primary">
                <i class="fas fa-download"></i>
                Get Extension
            </a>
            <a href="https://github.com/phplocator/phplocator" class="btn btn-secondary">
                <i class="fab fa-github"></i>
                GitHub
            </a>
        </div>
        
        <div class="demo-hint">
            <strong>🎯 Try it here and now:</strong><br>
            Hold Alt and hover over elements on this page, then click!<br>
            <small style="opacity: 0.8;">⬆️ This page is powered by PHP Locator</small>
        </div>
    </section>

    <section class="section features" id="extension">
        <div class="container">
            <h2>Speed up your PHP development</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Find anything faster</h3>
                    <p>Don't know every corner of your codebase? Find any component faster than ever. Click on any element to jump to its source code instantly.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3>Speed up your workflow</h3>
                    <p>Click on component ➡️ change code ➡️ check changes ➡️ and repeat by clicking on another component 🔁</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔧</div>
                    <h3>Zero Configuration</h3>
                    <p>Works out of the box! Just include one PHP file or use the browser extension. No complex setup required.</p>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="extension/extension.zip" class="btn btn-primary" style="font-size: 1.2rem; padding: 20px 40px;">
                    <i class="fas fa-download"></i>
                    Download Extension
                </a>
                <p style="margin-top: 1rem; color: #666;">
                    Works with Chrome, Edge, Firefox, Opera, and Safari
                </p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 PHP Locator — Inspired by <a href="https://locatorjs.com" target="_blank">LocatorJS</a></p>
            <p style="margin-top: 1rem;">
                <a href="https://github.com/phplocator/phplocator" target="_blank">GitHub</a> |
                <a href="standalone/zero-config-demo.php">Zero Config Demo</a> |
                <a href="standalone/manual-demo.php">Manual Demo</a>
            </p>
        </div>
    </footer>

    <script>
        console.log('🎯 PHP Locator Demo - Try Alt+hover+click on any element!');
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
