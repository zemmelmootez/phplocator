<?php
// Super detailed debug version
require_once '../standalone/phplocator.php';

// Show debug info
$currentFile = __FILE__;
$realPath = realpath($currentFile);

echo "<h2>Debug Information:</h2>";
echo "<pre>";
echo "Current file (__FILE__): " . $currentFile . "\n";
echo "Real path: " . $realPath . "\n";
echo "Backtrace:\n";
$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
foreach($backtrace as $i => $trace) {
    if (isset($trace['file'])) {
        echo "  [$i] " . $trace['file'] . "\n";
    }
}
echo "</pre>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Super Debug</title>
    <script>
        window.addEventListener('load', function() {
            console.log('=== ELEMENT DEBUG ===');
            const testDiv = document.querySelector('.test-element');
            if (testDiv) {
                console.log('Test div found:', {
                    'data-php-file': testDiv.getAttribute('data-php-file'),
                    'data-php-line': testDiv.getAttribute('data-php-line'),
                    'outerHTML': testDiv.outerHTML
                });
            }
            
            // Show all elements with data attributes
            const allElements = document.querySelectorAll('[data-php-file]');
            console.log('All elements with data-php-file:', allElements);
            allElements.forEach((el, i) => {
                console.log(`Element ${i}:`, {
                    tag: el.tagName,
                    file: el.getAttribute('data-php-file'),
                    line: el.getAttribute('data-php-line')
                });
            });
        });
    </script>
</head>
<body>
    <h1>Super Debug Test</h1>
    
    <div class="test-element">
        <p>This is a test paragraph</p>
        <button>Test Button</button>
    </div>
    
    <section>
        <h2>Another section</h2>
        <span>Test span</span>
    </section>
</body>
</html>
