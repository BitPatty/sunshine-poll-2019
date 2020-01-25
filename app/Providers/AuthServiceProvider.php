<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('read-votes', function (User $user) {
            if (!isset($user)) return false;
            if (!isset($user->src_name) || empty($user->src_name)) return false;
            $audits = array_unique(explode(',', env('ROLE_AUDIT') . ',' . env('ROLE_MOD') . ',' . env('ROLE_ADMIN')));
            return (in_array(strtolower($user->src_name), $audits));
        });

        Gate::define('update-votes', function (User $user) {
            if (!isset($user)) return false;
            if (!isset($user->src_name) || empty($user->src_name)) return false;
            $audits = array_unique(explode(',', env('ROLE_MOD')));
            return (in_array(strtolower($user->src_name), $audits));
        });

        Gate::define('read-results', function (User $user) {
            if (!isset($user)) return false;
            if (!isset($user->src_name) || empty($user->src_name)) return false;
            $audits = array_unique(explode(',', env('ROLE_MOD') . ',' . env('ROLE_ADMIN')));
            return (in_array(strtolower($user->src_name), $audits));
        });
    }
}
