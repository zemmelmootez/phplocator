// PHP Locator - Auto Detection (works exactly like LocatorJS)
(function() {
    'use strict';
    
    let holdingModKey = false;
    let currentElement = null;
    let currentHighlight = null;
    
    // Check modifier keys exactly like LocatorJS
    function isCombinationModifiersPressed(e, rightClick = false) {
        const modifiers = getMouseModifiers();
        
        if (rightClick) {
            return (
                e.altKey == !!modifiers.alt &&
                e.metaKey == !!modifiers.meta &&
                e.shiftKey == !!modifiers.shift
            );
        }
        return (
            e.altKey == !!modifiers.alt &&
            e.ctrlKey == !!modifiers.ctrl &&
            e.metaKey == !!modifiers.meta &&
            e.shiftKey == !!modifiers.shift
        );
    }
    
    function getMouseModifiers() {
        const mouseModifiers = document.documentElement.dataset.locatorMouseModifiers || "alt";
        const mouseModifiersArray = mouseModifiers.split("+");
        const modifiers = {};
        mouseModifiersArray.forEach((modifier) => {
            modifiers[modifier] = true;
        });
        return modifiers;
    }
    
    // Check if this is a PHP page or has PHP debug info
    function detectPHPPage() {
        // Look for PHP debug comments, error messages, or server headers
        const hasPhpContent = document.documentElement.outerHTML.includes('<?php') ||
                             document.querySelector('meta[name*="php"]') ||
                             document.querySelector('script[data-php-source]') ||
                             window.location.href.includes('.php') ||
                             document.querySelector('[data-php-file]');
        
        return hasPhpContent;
    }
    
    // Check if element is our own
    function isLocatorsOwnElement(element) {
        return (
            element.className == "phplocator-label" ||
            element.id == "phplocator-layer" ||
            element.id == "phplocator-wrapper" ||
            element.matches("#phplocator-wrapper *")
        );
    }
    
    // Auto-detect source info from DOM elements - prefer most specific element
    function getSourceInfo(element) {
        let sourceInfo = null;
        let targetElement = element;

        // Method 1: Check the clicked element first, then walk up the DOM tree
        while (targetElement && targetElement !== document.body) {
            if (targetElement.dataset.phpFile) {
                sourceInfo = {
                    file: targetElement.dataset.phpFile,
                    line: parseInt(targetElement.dataset.phpLine) || 1,
                    column: parseInt(targetElement.dataset.phpColumn) || 1
                };
                break; // Found it, stop searching
            }
            targetElement = targetElement.parentElement;
        }
        
        // Method 2: Try to infer from HTML comments
        if (!sourceInfo) {
            const htmlStr = element.outerHTML;
            const commentMatch = htmlStr.match(/<!--\s*PHP:\s*([^:]+):(\d+):?(\d+)?\s*-->/);
            if (commentMatch) {
                sourceInfo = {
                    file: commentMatch[1],
                    line: parseInt(commentMatch[2]),
                    column: parseInt(commentMatch[3]) || 1
                };
            }
        }
        
        // Method 3: Fallback - try to guess from current page
        if (!sourceInfo && window.location.pathname.endsWith('.php')) {
            sourceInfo = {
                file: window.location.pathname,
                line: 1,
                column: 1
            };
        }
        
        return sourceInfo;
    }
    
    // Open in IDE (exactly like LocatorJS approach)
    function openInIDE(sourceInfo) {
        if (!sourceInfo || !sourceInfo.file) return;
        
        console.log('[PHP Locator] Opening:', sourceInfo);
        
        // Convert relative path to absolute Windows path
        let filePath = sourceInfo.file;
        
        // If it's a URL path, convert to actual file path
        if (filePath.startsWith('/')) {
            // Assume web root is current directory for now
            const webRoot = 'C:/Users/mootez/phplocator/standalone';
            filePath = webRoot + filePath;
        }
        
        // LocatorJS uses this exact format: vscode://file/${projectPath}${filePath}:${line}:${column}
        // The filePath from data-php-file should be the complete absolute path
        // Just use it directly with forward slashes for VS Code
        const normalizedPath = filePath.replace(/\\/g, '/');
        
        // Build VS Code URL with the full absolute path
        const vscodeUrl = `vscode://file/${normalizedPath}:${sourceInfo.line}:${sourceInfo.column}`;
        
        console.log('[PHP Locator] Original File Path:', filePath);
        console.log('[PHP Locator] Normalized Path:', normalizedPath);
        console.log('[PHP Locator] Final URL:', vscodeUrl);
        
        try {
            // Use exactly the same approach as LocatorJS: window.open with "_self" target
            window.open(vscodeUrl, '_self');
        } catch (e) {
            console.error('[PHP Locator] Failed to open:', e);
        }
    }
    
    // Create highlight overlay exactly like LocatorJS
    function createHighlight(element) {
        removeHighlight();
        
        const rect = element.getBoundingClientRect();
        const highlight = document.createElement('div');
        
        // Use LocatorJS colors and styling
        highlight.style.cssText = `
            position: fixed;
            top: ${rect.top}px;
            left: ${rect.left}px;
            width: ${rect.width}px;
            height: ${rect.height}px;
            background: rgba(138, 43, 226, 0.1);
            border: 2px solid #8a2be2;
            pointer-events: none;
            z-index: 999999;
            border-radius: 4px;
            box-shadow: 0 0 0 1px rgba(138, 43, 226, 0.3);
        `;
        
        document.body.appendChild(highlight);
        currentHighlight = highlight;
        
        // Add source info label
        const sourceInfo = getSourceInfo(element);
        if (sourceInfo) {
            const label = document.createElement('div');
            label.style.cssText = `
                position: fixed;
                top: ${rect.top - 25}px;
                left: ${rect.left}px;
                background: #8a2be2;
                color: white;
                padding: 4px 8px;
                font-size: 12px;
                font-family: monospace;
                border-radius: 3px;
                z-index: 1000000;
                pointer-events: none;
                white-space: nowrap;
            `;
            label.textContent = `${sourceInfo.file.split('/').pop()}:${sourceInfo.line}`;
            document.body.appendChild(label);
            currentHighlight.label = label;
        }
    }
    
    function removeHighlight() {
        if (currentHighlight) {
            if (currentHighlight.label) {
                currentHighlight.label.remove();
            }
            currentHighlight.remove();
            currentHighlight = null;
        }
    }
    
    // Event handlers exactly like LocatorJS Runtime.tsx
    function keyUpListener(e) {
        holdingModKey = isCombinationModifiersPressed(e);
        updateUI();
    }
    
    function keyDownListener(e) {
        holdingModKey = isCombinationModifiersPressed(e, true);
        updateUI();
    }
    
    function mouseOverListener(e) {
        const target = e.target;
        if (target && target instanceof HTMLElement) {
            // Ignore our own elements
            if (isLocatorsOwnElement(target)) {
                return;
            }
            
            holdingModKey = isCombinationModifiersPressed(e, true);
            currentElement = target;
            updateUI();
        }
    }
    
    function clickListener(e) {
        if (!isCombinationModifiersPressed(e)) {
            return;
        }
        
        const target = e.target;
        if (target && target instanceof HTMLElement) {
            if (target.shadowRoot) {
                return;
            }
            
            if (isLocatorsOwnElement(target)) {
                return;
            }
            
            const sourceInfo = getSourceInfo(target);
            if (sourceInfo) {
                e.preventDefault();
                e.stopPropagation();
                openInIDE(sourceInfo);
            }
        }
    }
    
    function updateUI() {
        if (holdingModKey && currentElement) {
            const sourceInfo = getSourceInfo(currentElement);
            if (sourceInfo) {
                createHighlight(currentElement);
                document.body.style.cursor = 'pointer';
                document.body.classList.add("phplocator-active-pointer");
            } else {
                removeHighlight();
                document.body.style.cursor = 'default';
                document.body.classList.remove("phplocator-active-pointer");
            }
        } else {
            removeHighlight();
            document.body.style.cursor = 'default';
            document.body.classList.remove("phplocator-active-pointer");
        }
    }
    
    // Initialize exactly like LocatorJS Runtime does
    function init() {
        if (!detectPHPPage()) {
            console.log('[PHP Locator] Not a PHP page, skipping');
            return;
        }
        
        console.log('[PHP Locator] Auto-detection enabled on PHP page');
        
        // Set up mouse modifier detection
        document.documentElement.dataset.locatorMouseModifiers = "alt";
        
        // Add all event listeners like LocatorJS Runtime.tsx
        const roots = [document];
        document.querySelectorAll("*").forEach((node) => {
            if (node.id === "phplocator-wrapper") {
                return;
            }
            if (node.shadowRoot) {
                roots.push(node.shadowRoot);
            }
        });
        
        for (const root of roots) {
            root.addEventListener("mouseover", mouseOverListener, {
                capture: true,
            });
            root.addEventListener("keydown", keyDownListener);
            root.addEventListener("keyup", keyUpListener);
            root.addEventListener("click", clickListener, {
                capture: true,
            });
        }
        
        // Inject CSS for smooth experience
        const style = document.createElement('style');
        style.textContent = `
            .phplocator-active-pointer {
                cursor: pointer !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Start when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
