<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Tikoikoon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="mb-8">
            <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>
            <h1 class="text-6xl font-bold text-white mb-4">404</h1>
            <h2 class="text-2xl font-semibold text-gray-300 mb-4">Page Not Found</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                Sorry, the page you are looking for doesn't exist or has been moved.
            </p>
        </div>
        
        <div class="space-x-4">
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-home mr-2"></i>
                Go Home
            </a>
            <button onclick="history.back()" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Go Back
            </button>
        </div>
        
        <div class="mt-12">
            <p class="text-sm text-gray-500">
                If you think this is an error, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
