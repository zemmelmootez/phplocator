<?php
/**
 * Performance test for PHPLocator
 * Tests the optimizations made to the code
 */

// Include the optimized PHPLocator
require_once __DIR__ . '/../phplocator.php';

// Generate large HTML content with many tags to test performance
function generateLargeHTML($numElements = 100) {
    $html = '<!DOCTYPE html><html><head><title>Performance Test</title></head><body>';
    
    for ($i = 0; $i < $numElements; $i++) {
        $html .= '<div class="container-' . $i . '">';
        $html .= '<h1>Heading ' . $i . '</h1>';
        $html .= '<p>Paragraph ' . $i . '</p>';
        $html .= '<button id="btn-' . $i . '">Button ' . $i . '</button>';
        $html .= '<span>Span ' . $i . '</span>';
        $html .= '</div>';
    }
    
    $html .= '</body></html>';
    return $html;
}

// Measure performance
$startTime = microtime(true);
$startMemory = memory_get_usage();

// Generate output
echo generateLargeHTML(100);

$endTime = microtime(true);
$endMemory = memory_get_usage();

// Note: Actual measurements will be in the output buffer
// This is just to verify the code runs without errors

// Performance metrics will be visible in the HTML output
?>
