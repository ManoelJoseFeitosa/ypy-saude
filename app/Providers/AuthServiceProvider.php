<?php

namespace App\Providers;

use App\Models\User;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Define um Gate para verificar se o utilizador tem o papel 'medico'.
         * A rota pode usar este gate com o middleware: ->middleware('can:is-medico');
         */
        Gate::define('is-medico', function (User $user) {
            return $user->tipo === 'medico';
        });

        /**
         * Define um Gate para verificar se o utilizador tem o papel 'paciente'.
         * A rota pode usar este gate com o middleware: ->middleware('can:is-paciente');
         */
        Gate::define('is-paciente', function (User $user) {
            return $user->tipo === 'paciente';
        });
    }
}
