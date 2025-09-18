protected $routeMiddleware = [
    // ... other middleware
    'admin.auth' => \App\Http\Middleware\AdminAuth::class,
    'manager.auth' => \App\Http\Middleware\ManagerAuth::class,
];