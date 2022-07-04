<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Dashboard;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        // DOC : register new permissions to show in user edit form
        $permissions = ItemPermission::group('quality')
            ->addPermission('platform.quality.wealths', __('wealths'))
            ->addPermission('platform.quality.wealths.create', __('wealth_create'))
            ->addPermission('platform.quality.wealths.edit', __('wealth_edit'))    
            ->addpermission('platform.search', __('search'));

        $dashboard->registerPermissions($permissions);
    }
}
