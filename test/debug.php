<?php
// Debug version to show what file is being detected
require_once '../standalone/phplocator.php';

// Get the current file info
$currentFile = __FILE__;
echo "<pre>Debug Info:\n";
echo "Current file (__FILE__): " . $currentFile . "\n";
echo "Real path: " . realpath($currentFile) . "\n";
echo "</pre>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug PHP Locator</title>
</head>
<body>
    <h1>Debug Test</h1>
    <div class="test">
        <p>This paragraph should now point to the correct file!</p>
        <button>Click me to test VS Code opening</button>
    </div>
</body>
</html>
