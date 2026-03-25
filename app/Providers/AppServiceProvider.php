<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;   

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force Laravel à générer des URLs en HTTPS en production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Optimisation du prefetch Vite
        Vite::prefetch(concurrency: 3);
        
        // Partage de l'utilisateur connecté avec Inertia
        Inertia::share([
            'auth' => function () {
                if ($user = Auth::user()) {
                    return [
                        'user' => [
                            'id'    => $user->id,
                            'name'  => $user->name,
                            'email' => $user->email,
                            'role'  => $user->role, // suppose que tu as une colonne "role"
                        ],
                    ];
                }
                return [];
            },
        ]);

        // Partage notifications non lues
        Inertia::share([
            'auth' => fn () => [
                'user' => Auth::user(),
                'unread_notifications' => Auth::user()?->unreadNotifications()->count() ?? 0,
            ],
        ]);
    }
}
