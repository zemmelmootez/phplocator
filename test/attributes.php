<?php
require_once '../standalone/phplocator.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attribute Test</title>
    <script>
        window.addEventListener('load', function() {
            console.log('=== DATA ATTRIBUTE DEBUG ===');
            const elements = document.querySelectorAll('[data-php-file]');
            elements.forEach((el, index) => {
                console.log(`Element ${index}:`, {
                    tag: el.tagName,
                    file: el.getAttribute('data-php-file'),
                    line: el.getAttribute('data-php-line'),
                    element: el
                });
            });
        });
    </script>
</head>
<body>
    <h1>Data Attribute Test</h1>
    
    <div class="test-div">
        <p>Test paragraph</p>
        <button>Test button</button>
    </div>
    
    <section class="another-section">
        <h2>Another heading</h2>
        <span>Test span</span>
    </section>
</body>
</html>
