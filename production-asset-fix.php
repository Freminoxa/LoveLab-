<?php

// This is a temporary fix for production
// Replace the @vite directive with direct asset links

$layoutFile = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($layoutFile);

// Replace Vite directive with direct asset links
$newContent = str_replace(
    '@vite([\'resources/css/app.css\', \'resources/js/app.js\'])',
    '<link rel="stylesheet" href="{{ asset(\'build/assets/app-r4ONkJxw.css\') }}">
    <script src="{{ asset(\'build/assets/app-mqn37bar.js\') }}" defer></script>',
    $content
);

// Create backup
file_put_contents($layoutFile . '.backup', $content);

// Apply fix
file_put_contents($layoutFile, $newContent);

echo "Production asset fix applied. Backup saved as app.blade.php.backup\n";
echo "Remember to revert this when Vite is working properly.\n";

?>
