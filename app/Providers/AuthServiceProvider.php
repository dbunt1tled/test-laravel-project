<?php

namespace App\Providers;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Banner\Banner;
use App\Entity\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;
use Laravel\Passport\Passport;

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
        $this->registerPermission();
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Horizon::auth(function ($request) {
            return Gate::allows('horizon');
        });
    }
    private function registerPermission(): void
    {
        Gate::define('horizon',function (User $user){
            return ($user->isAdmin() || $user->isModerator());
        });
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
        Gate::define('manage-banners', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('manage-own-banner', function (User $user, Banner $banner) {
            return $banner->user_id === $user->id;
        });
    }
}
