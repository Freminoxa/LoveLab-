<?php

// Fix font loading and CORS issues in production
$layoutFile = 'resources/views/layouts/app.blade.php';

if (file_exists($layoutFile)) {
    $content = file_get_contents($layoutFile);
    
    // Add preconnect and better font loading
    $fontFix = '<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">';
    
    // Replace existing font loading
    $content = preg_replace(
        '/<link rel="preconnect".*?crossorigin>.*?<link href="https:\/\/fonts\.googleapis\.com.*?rel="stylesheet">/s',
        $fontFix,
        $content
    );
    
    // Add proper meta tags for CORS
    $metaTags = '<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="font-src \'self\' https://fonts.gstatic.com data:; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://cdnjs.cloudflare.com;">
    <link rel="icon" type="image/png" href="{{ asset(\'images/logo.png\') }}">
    <link rel="apple-touch-icon" href="{{ asset(\'images/logo.png\') }}">';
    
    // Replace the meta section
    $content = preg_replace(
        '/<meta name="csrf-token".*?<link rel="apple-touch-icon"[^>]*>/s',
        $metaTags,
        $content
    );
    
    // Write the updated content
    file_put_contents($layoutFile, $content);
    
    echo "Font loading and CORS issues fixed!\n";
} else {
    echo "Layout file not found!\n";
}

?>
