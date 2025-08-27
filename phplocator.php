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
    private $initialized = false;
    
    public static function init() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Start output buffering immediately
        if (ob_get_level() === 0) {
            ob_start();
        }
        register_shutdown_function([$this, 'processOutput']);
    }
    
    private function findSourceFile() {
        if ($this->initialized) {
            return;
        }
        
        // Get the current backtrace to find the main PHP file
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        // Look for the file that's actually being executed (not vendor/autoload files)
        $this->sourceFile = null;
        foreach ($backtrace as $trace) {
            if (isset($trace['file'])) {
                $file = $trace['file'];
                
                // Skip Composer vendor files and phplocator itself
                if (basename($file) !== 'phplocator.php' && 
                    strpos($file, 'vendor/') === false &&
                    strpos($file, 'vendor\\') === false) {
                    $this->sourceFile = $file;
                    break;
                }
            }
        }
        
        // If we couldn't find a good file from backtrace, use the main script
        if ($this->sourceFile === null && isset($_SERVER['SCRIPT_FILENAME'])) {
            $this->sourceFile = $_SERVER['SCRIPT_FILENAME'];
        }
        
        // Last resort - use the first non-vendor file in backtrace
        if ($this->sourceFile === null) {
            foreach ($backtrace as $trace) {
                if (isset($trace['file']) && 
                    strpos($trace['file'], 'vendor/') === false &&
                    strpos($trace['file'], 'vendor\\') === false) {
                    $this->sourceFile = $trace['file'];
                    break;
                }
            }
        }
        
        // Read source code
        if ($this->sourceFile && file_exists($this->sourceFile)) {
            $this->sourceLines = file($this->sourceFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        
        $this->initialized = true;
    }
    
    public function processOutput() {
        // Initialize file detection if not done yet
        $this->findSourceFile();
        
        // Get buffered content
        $html = '';
        if (ob_get_level() > 0) {
            $html = ob_get_contents();
            ob_end_clean();
        }
        
        // Only process if we actually have HTML content
        if (empty($html)) {
            return;
        }
        
        // Add debug comment to show which file is being tracked
        $debugComment = "<!-- PHP Locator: Tracking file: " . ($this->sourceFile ?: 'unknown') . " -->\n";
        
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
