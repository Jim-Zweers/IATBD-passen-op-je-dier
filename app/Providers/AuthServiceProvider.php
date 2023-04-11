<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enums\Role;
use App\Models\Pet;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Policies\PolicyForPet;
use App\Policies\PolicyForRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Pet::class => PolicyForPet::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // example gate authorazation
        Gate::define('update-pet', [PolicyForPet::class, 'update']);
        Gate::define('store-pet', [PolicyForPet::class, 'store']);
        Gate::define('store-request', [PolicyForRequest::class, 'store']);

        // Calling gate in model
        // $this->authorize('update-pet', $pet);

        // Admin gate to grant all permissions
        Gate::before(function ($user, $ability) {
            if($user->role == Role::Admin) {
                return true;
            }
        });
    }
}
