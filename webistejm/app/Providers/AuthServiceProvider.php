<!-- <?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\PlaintextGuard;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('plaintext', function ($app, $name, array $config) {
            return new PlaintextGuard(
                Auth::createUserProvider($config['provider']),
                $app['session.store'],
                $app->make('request')
            );
        });
    }
} -->
