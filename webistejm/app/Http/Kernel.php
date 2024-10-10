protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'check.session' => \App\Http\Middleware\CheckSession::class,
    // ... other middleware
];
