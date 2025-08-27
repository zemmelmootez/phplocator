<?php
/**
 * PHP Locator - Automatic Code Injection
 * Zero configuration required - just include this file and it works!
 * Inspired by LocatorJS - automatically injects data attributes for click-to-code
 */

class PHPLocator {
    private static $instance = null;
    private $sourceFile = null;
    private $sourceLines = [];
    
    public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Get the main PHP file (the one that includes this script)
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        // Find the file that included phplocator.php (not phplocator.php itself)
        $this->sourceFile = null;
        foreach ($backtrace as $trace) {
            if (isset($trace['file']) && basename($trace['file']) !== 'phplocator.php') {
                $this->sourceFile = $trace['file'];
                break;
            }
        }
        
        // Fallback to the last file in backtrace if not found
        if ($this->sourceFile === null) {
            $this->sourceFile = $backtrace[count($backtrace) - 1]['file'];
        }
        
        // Read source code
        if (file_exists($this->sourceFile)) {
            $this->sourceLines = file($this->sourceFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        
        // Start output buffering to process HTML
        ob_start();
        register_shutdown_function([$this, 'processOutput']);
    }
    
    public function processOutput() {
        $html = ob_get_contents();
        if (ob_get_level() > 0) {
            ob_clean();
        }
        
        // Add debug comment to show which file is being tracked
        $debugComment = "<!-- PHP Locator: Tracking file: " . $this->sourceFile . " -->\n";
        
        // Process HTML and inject data attributes
        $processedHtml = $this->injectDataAttributes($html);
        
        // Insert debug comment after <head> or at the beginning
        if (strpos($processedHtml, '<head>') !== false) {
            $processedHtml = str_replace('<head>', "<head>\n" . $debugComment, $processedHtml);
        } else {
            $processedHtml = $debugComment . $processedHtml;
        }
        
        echo $processedHtml;
    }
    
    private function injectDataAttributes($html) {
        // Match HTML opening tags
        return preg_replace_callback(
            '/<([a-zA-Z][a-zA-Z0-9]*)\b([^>]*?)(\s*\/?)>/m',
            [$this, 'addDataAttributes'],
            $html
        );
    }
    
    private function addDataAttributes($matches) {
        $tagName = $matches[1];
        $attributes = $matches[2];
        $selfClosing = $matches[3];
        
        // Skip if already has data-php-file attribute
        if (strpos($attributes, 'data-php-file') !== false) {
            return $matches[0];
        }
        
        // Skip script, style, and meta tags
        if (in_array($tagName, ['script', 'style', 'meta', 'link', 'title'])) {
            return $matches[0];
        }
        
        // Find line number for this tag
        $lineNumber = $this->findLineNumber($matches[0], $tagName);
        
        if ($lineNumber !== null) {
            $file = str_replace('\\', '/', $this->sourceFile);
            $newAttributes = $attributes . 
                ' data-php-file="' . htmlspecialchars($file) . '"' .
                ' data-php-line="' . $lineNumber . '"';
            
            return '<' . $tagName . $newAttributes . $selfClosing . '>';
        }
        
        return $matches[0];
    }
    
    private function findLineNumber($fullTag, $tagName) {
        // Clean the tag for better matching
        $cleanTag = preg_replace('/\s+/', ' ', trim($fullTag));
        $tagPattern = strtolower($tagName);
        
        foreach ($this->sourceLines as $lineNum => $line) {
            $cleanLine = preg_replace('/\s+/', ' ', trim($line));
            
            // Skip PHP code lines
            if (strpos($line, '<?php') !== false || 
                strpos($line, '<?=') !== false ||
                strpos($line, '?>') !== false ||
                strpos($line, '//') === 0 ||
                strpos($line, '/*') !== false ||
                strpos($line, '*') === 0) {
                continue;
            }
            
            // Look for the tag in this line
            if (stripos($cleanLine, '<' . $tagPattern) !== false) {
                // Additional checks to make sure this is the right tag
                if ($this->isMatchingTag($cleanLine, $cleanTag, $tagPattern)) {
                    return $lineNum + 1; // Line numbers are 1-based
                }
            }
        }
        
        return null;
    }
    
    private function isMatchingTag($sourceLine, $targetTag, $tagName) {
        // Extract key attributes from both tags for comparison
        $sourceAttrs = $this->extractKeyAttributes($sourceLine);
        $targetAttrs = $this->extractKeyAttributes($targetTag);
        
        // If target has class/id, source must match
        foreach (['class', 'id'] as $attr) {
            if (isset($targetAttrs[$attr]) && isset($sourceAttrs[$attr])) {
                if ($targetAttrs[$attr] === $sourceAttrs[$attr]) {
                    return true;
                }
            }
        }
        
        // If no specific attributes, match by context (position in line)
        return stripos($sourceLine, '<' . $tagName) !== false;
    }
    
    private function extractKeyAttributes($tag) {
        $attrs = [];
        
        // Extract class
        if (preg_match('/class=[\'"](.*?)[\'"]/', $tag, $matches)) {
            $attrs['class'] = $matches[1];
        }
        
        // Extract id
        if (preg_match('/id=[\'"](.*?)[\'"]/', $tag, $matches)) {
            $attrs['id'] = $matches[1];
        }
        
        return $attrs;
    }
}

// Auto-initialize when this file is included
PHPLocator::init();
?>
