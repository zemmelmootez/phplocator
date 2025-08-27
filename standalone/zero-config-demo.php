<?php
// Just include phplocator.php - that's it! Zero configuration needed!
require_once 'phplocator.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Auto PHP Locator - Zero Config Demo</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 40px; 
            line-height: 1.6; 
        }
        .container { 
            max-width: 800px; 
            margin: 0 auto; 
        }
        .card { 
            border: 1px solid #ddd; 
            padding: 20px; 
            margin: 20px 0; 
            border-radius: 8px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .highlight { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px; 
            margin: 15px 0; 
            border-radius: 8px;
        }
        button { 
            background: #007cba; 
            color: white; 
            padding: 12px 24px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }
        button:hover { 
            background: #005a8b; 
            transform: translateY(-1px);
        }
        .alert { 
            background: #f8f9fa; 
            border-left: 4px solid #007cba; 
            padding: 15px; 
            margin: 15px 0; 
        }
        ul { list-style-type: none; padding: 0; }
        li { 
            background: #f8f9fa; 
            margin: 8px 0; 
            padding: 12px; 
            border-radius: 4px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 PHP Locator - Zero Configuration!</h1>
        
        <div class="alert">
            <strong>Instructions:</strong> Hold Alt and hover over any element, then click to open in VS Code!
            <br>No wrapper functions needed - everything is automatic!
        </div>
        
        <div class="card">
            <h2>Welcome Card</h2>
            <p>This paragraph will open at its exact line number in the source code.</p>
            <button onclick="alert('Button works!')">Click Me</button>
            <button onclick="console.log('Another button')">Console Log</button>
        </div>
        
        <div class="highlight">
            <h3>Highlighted Section</h3>
            <p>This content has automatic data attributes injected by PHP Locator.</p>
            <p>Each element will point to its exact line in the PHP file.</p>
        </div>
        
        <div class="card">
            <h3>Dynamic Content</h3>
            <?php 
            $features = [
                'Automatic data attribute injection',
                'Zero configuration required', 
                'Works with any existing PHP code',
                'Precise line number detection'
            ];
            ?>
            <ul>
                <?php foreach ($features as $feature): ?>
                    <li>✅ <?= $feature ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="card">
            <h3>Test Nested Elements</h3>
            <div class="highlight">
                <p>Nested paragraph inside highlight div</p>
                <button>Nested Button</button>
            </div>
        </div>
    </div>
    
    <script>
        console.log('🎯 PHP Locator loaded! Alt+hover+click on any element to open its source.');
    </script>
</body>
</html>
