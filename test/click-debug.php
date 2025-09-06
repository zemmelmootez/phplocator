<?php
require_once '../standalone/phplocator.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Click Debug Test</title>
    <style>
        .debug-info {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #f0f0f0;
            border: 2px solid #333;
            padding: 10px;
            font-family: monospace;
            font-size: 12px;
            max-width: 400px;
            z-index: 10000;
        }
        body { margin: 40px; font-family: Arial, sans-serif; }
        .test-element { border: 2px dashed #ccc; padding: 20px; margin: 10px 0; }
    </style>
    <script>
        // Override the PHP Locator extension's click handler to add debug
        window.addEventListener('load', function() {
            // Create debug display
            const debugDiv = document.createElement('div');
            debugDiv.className = 'debug-info';
            debugDiv.innerHTML = '<strong>Debug Info</strong><br>Click any element while holding Alt';
            document.body.appendChild(debugDiv);
            
            // Add click listener to show what data attributes exist
            document.addEventListener('click', function(e) {
                if (e.altKey) {
                    console.log('=== CLICK DEBUG ===');
                    console.log('Clicked element:', e.target);
                    console.log('Element tag:', e.target.tagName);
                    console.log('data-php-file:', e.target.getAttribute('data-php-file'));
                    console.log('data-php-line:', e.target.getAttribute('data-php-line'));
                    console.log('dataset.phpFile:', e.target.dataset.phpFile);
                    console.log('dataset.phpLine:', e.target.dataset.phpLine);
                    console.log('outerHTML:', e.target.outerHTML.substring(0, 200));
                    
                    // Update debug display
                    debugDiv.innerHTML = `
                        <strong>Debug Info</strong><br>
                        Tag: ${e.target.tagName}<br>
                        data-php-file: ${e.target.getAttribute('data-php-file')}<br>
                        data-php-line: ${e.target.getAttribute('data-php-line')}<br>
                        dataset.phpFile: ${e.target.dataset.phpFile}<br>
                        dataset.phpLine: ${e.target.dataset.phpLine}
                    `;
                    
                    // Walk up DOM tree
                    let parent = e.target.parentElement;
                    let level = 1;
                    while (parent && level < 5) {
                        if (parent.getAttribute('data-php-file')) {
                            console.log(`Parent level ${level}:`, {
                                tag: parent.tagName,
                                file: parent.getAttribute('data-php-file'),
                                line: parent.getAttribute('data-php-line')
                            });
                        }
                        parent = parent.parentElement;
                        level++;
                    }
                }
            }, true); // Use capture phase
        });
    </script>
</head>
<body>
    <h1>Click Debug Test</h1>
    
    <div class="test-element">
        <h2>Test Section</h2>
        <p>Click this paragraph while holding Alt</p>
        <button>Or click this button</button>
    </div>
    
    <div class="test-element">
        <h3>Another Section</h3>
        <span>Click this span</span>
        <div>Or this nested div</div>
    </div>
</body>
</html>
