<?php
// Inline PHP Locator for testing - no external dependencies

class TestPHPLocator {
    private $sourceFile;
    private $sourceLines;
    
    public function __construct() {
        // Get the current file
        $this->sourceFile = __FILE__;
        
        echo "<pre>CONSTRUCTOR DEBUG:\n";
        echo "Source file: " . $this->sourceFile . "\n";
        echo "Real path: " . realpath($this->sourceFile) . "\n";
        echo "</pre>";
        
        // Read source code
        if (file_exists($this->sourceFile)) {
            $this->sourceLines = file($this->sourceFile, FILE_IGNORE_NEW_LINES);
        }
        
        // Start output buffering
        ob_start();
        register_shutdown_function([$this, 'processOutput']);
    }
    
    public function processOutput() {
        $html = ob_get_contents();
        if (ob_get_level() > 0) {
            ob_clean();
        }
        
        // Simple injection - just add data attributes to div and p tags
        $html = preg_replace_callback(
            '/<(div|p|h1|h2|h3|button|section|span)\b([^>]*?)>/i',
            function($matches) {
                $tag = $matches[1];
                $attributes = $matches[2];
                
                // Don't add if already has data-php-file
                if (strpos($attributes, 'data-php-file') !== false) {
                    return $matches[0];
                }
                
                // Add data attributes
                $file = str_replace('\\', '/', $this->sourceFile);
                $line = $this->findLineForTag($matches[0]);
                
                $newAttributes = $attributes . 
                    ' data-php-file="' . htmlspecialchars($file) . '"' .
                    ' data-php-line="' . $line . '"';
                
                return '<' . $tag . $newAttributes . '>';
            },
            $html
        );
        
        echo $html;
    }
    
    private function findLineForTag($tag) {
        // Simple line finding - just return a test line number
        return rand(20, 50); // For testing
    }
}

// Initialize
new TestPHPLocator();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Self-Contained Test</title>
    <script>
        window.addEventListener('load', function() {
            console.log('=== INLINE TEST DEBUG ===');
            const elements = document.querySelectorAll('[data-php-file]');
            console.log('Found elements:', elements.length);
            elements.forEach((el, i) => {
                console.log(`Element ${i}:`, {
                    tag: el.tagName,
                    file: el.getAttribute('data-php-file'),
                    line: el.getAttribute('data-php-line'),
                    outerHTML: el.outerHTML.substring(0, 100) + '...'
                });
            });
        });
    </script>
</head>
<body>
    <h1>Self-Contained Test</h1>
    
    <div class="test-container">
        <p>This paragraph should have the correct file path</p>
        <button>This button too</button>
    </div>
    
    <section>
        <h2>Section heading</h2>
        <span>Span element</span>
    </section>
</body>
</html>
