<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-works-shared', function(User $user) {
            // Approved Users and Admin
            return ($user->user_role_id == 1 && in_array($user->type, ['og', 'super'])) || ($user->user_role_id == null && $user->type == "normal" && in_array($user->verified, [0, 1]));
        });

        Gate::define('access-works-og', function(User $user) {
            // Admin Only
            return ($user->user_role_id == 1 && in_array($user->type, ['og', 'super']));
        });
    }
}
