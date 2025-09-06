<?php
// Test PHP Locator with dynamic file detection
require_once '../standalone/phplocator.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test PHP Locator</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .card { border: 1px solid #ddd; padding: 20px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>Testing PHP Locator</h1>
    
    <div class="card">
        <h2>Test Card</h2>
        <p>This should open the correct file now!</p>
        <button>Test Button</button>
    </div>
    
    <div class="another-card">
        <h3>Another Section</h3>
        <p>Each element should point to THIS file, not the hardcoded path.</p>
    </div>
    
    <script>
        console.log('Hold Alt and click any element!');
    </script>
</body>
</html>
