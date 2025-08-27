<?php
// NO WRAPPER FUNCTIONS! Just add data attributes directly to HTML elements
// This shows the correct line numbers for each element
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Locator - Manual Data Attributes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { border: 1px solid #ddd; padding: 20px; margin: 10px 0; border-radius: 5px; }
        .highlight { background-color: #f0f0f0; padding: 10px; margin: 10px 0; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer; }
        button:hover { background: #005a8b; }
    </style>
</head>
<body>
    <div class="container" data-php-file="<?= __FILE__ ?>" data-php-line="15">
        <h1 data-php-file="<?= __FILE__ ?>" data-php-line="16">PHP Locator Demo - No Wrapper Functions!</h1>
        
        <p data-php-file="<?= __FILE__ ?>" data-php-line="18">Hold Alt and hover over elements, then click to open in VS Code!</p>
        
        <div class="card" data-php-file="<?= __FILE__ ?>" data-php-line="20">
            <h2 data-php-file="<?= __FILE__ ?>" data-php-line="21">Card Title</h2>
            <p data-php-file="<?= __FILE__ ?>" data-php-line="22">This paragraph is on line 22</p>
            <button data-php-file="<?= __FILE__ ?>" data-php-line="23" onclick="alert('Button clicked!')">Click Me (Line 23)</button>
        </div>
        
        <div class="highlight" data-php-file="<?= __FILE__ ?>" data-php-line="26">
            <h3 data-php-file="<?= __FILE__ ?>" data-php-line="27">Nested Content</h3>
            <p data-php-file="<?= __FILE__ ?>" data-php-line="28">This content is properly nested with correct line numbers</p>
            <ul data-php-file="<?= __FILE__ ?>" data-php-line="29">
                <li data-php-file="<?= __FILE__ ?>" data-php-line="30">List item 1 (Line 30)</li>
                <li data-php-file="<?= __FILE__ ?>" data-php-line="31">List item 2 (Line 31)</li>
                <li data-php-file="<?= __FILE__ ?>" data-php-line="32">List item 3 (Line 32)</li>
            </ul>
        </div>
        
        <?php
        // Dynamic content with correct line numbers
        $items = ['Apple', 'Banana', 'Cherry'];
        ?>
        <div class="card" data-php-file="<?= __FILE__ ?>" data-php-line="39">
            <h3 data-php-file="<?= __FILE__ ?>" data-php-line="40">Dynamic Content</h3>
            <?php foreach ($items as $index => $item): ?>
                <p data-php-file="<?= __FILE__ ?>" data-php-line="42">Item <?= $index + 1 ?>: <?= $item ?></p>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
        console.log('Manual demo loaded - each element has correct line numbers!');
    </script>
</body>
</html>
