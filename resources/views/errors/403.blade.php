<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Forbidden - Tikoikoon</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="mb-8">
            <i class="fas fa-lock text-6xl text-red-500 mb-4"></i>
            <h1 class="text-6xl font-bold text-white mb-4">403</h1>
            <h2 class="text-2xl font-semibold text-gray-300 mb-4">Access Forbidden</h2>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                You don't have permission to access this resource.
            </p>
        </div>
        
        <div class="space-x-4">
            <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-home mr-2"></i>
                Go Home
            </a>
            <a href="{{ route('manager.login') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login
            </a>
        </div>
        
        <div class="mt-12">
            <p class="text-sm text-gray-500">
                Need access? Contact the administrator.
            </p>
        </div>
    </div>
</body>
</html>
