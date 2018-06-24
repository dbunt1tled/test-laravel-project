<?php

namespace App\Providers;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-panel',function (User $user){
            return ($user->isAdmin() || $user->isModerator());
        });
        Gate::define('users.manage',function (User $user){
            return ($user->isAdmin());
        });
        Gate::define('region.manage',function (User $user){
            return ($user->isAdmin());
        });
        Gate::define('adverts.category.manage',function (User $user){
            return ($user->isAdmin());
        });
        Gate::define('adverts.category.attribute.manage',function (User $user){
            return ($user->isAdmin());
        });
        Gate::define('edit-own-advert',function (User $user, Advert $advert){
            return $advert->user_id === $user->id;
        });
        Gate::define('show-advert',function (User $user, Advert $advert){
            return $advert->user_id === $user->id;
        });
        Gate::define('manage-adverts', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });
        Gate::define('manage-adverts-categories', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
        Gate::define('manage-adverts', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
    }
}
