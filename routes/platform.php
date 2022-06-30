<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Wealth\WealthListScreen;
use App\Orchid\Screens\Wealth\WealthEditScreen;
use App\Orchid\Screens\Search\SearchScreen;
use App\Orchid\Screens\Search\ResultScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/dashboard', PlatformScreen::class)
    ->name('platform.dashboard');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

//platform > quality > search
Route::screen('quality/search', SearchScreen::class)
    ->name('platform.quality.search')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('search'), route('platform.quality.search'));
    });

//platform > quality > search > result
Route::screen('quality/search/result/{wealths?}', ResultScreen::class)
    ->name('platform.quality.search.result')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.quality.search')
            ->push(__('result'), route('platform.quality.search.result'));
    });

// Platform > quality > wealths
Route::screen('wealths', WealthListScreen::class)
    ->name('platform.quality.wealths')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('wealths'), route('platform.quality.wealths'));
    });

// Platform > Quality > wealths > Wealth
Route::screen('wealths/{wealth}/edit', WealthEditScreen::class)
    ->name('platform.quality.wealths.edit')
    ->breadcrumbs(function (Trail $trail, $wealth) {
        return $trail
            ->parent('platform.quality.wealths')
            ->push(__('wealth'), route('platform.quality.wealths.edit', $wealth));
    });

// Platform > Quality > wealths > Create
Route::screen('wealths/create', WealthEditScreen::class)
    ->name('platform.quality.wealths.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.quality.wealths')
            ->push(__('Create'), route('platform.quality.wealths.create'));
    });
