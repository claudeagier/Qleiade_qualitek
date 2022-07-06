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
        // NEW_FORM register new permissions to show in user edit form
        $permissions = ItemPermission::group('quality')
            ->addpermission('platform.search', __('search'))
            // wealths admin form (proof)
            ->addPermission('platform.quality.wealths', __('wealths'))
            ->addPermission('platform.quality.wealths.create', __('wealth_create'))
            ->addPermission('platform.quality.wealths.edit', __('wealth_edit'))
            // Tags admin form
            ->addPermission('platform.quality.tags', __('tags'))
            ->addPermission('platform.quality.tags.create', __('tag_create'))
            ->addPermission('platform.quality.tags.edit', __('tag_edit'))
            // Actions admin form
            ->addPermission('platform.quality.actions', __('actions'))
            ->addPermission('platform.quality.actions.create', __('action_create'))
            ->addPermission('platform.quality.actions.edit', __('action_edit'));

        $dashboard->registerPermissions($permissions);
    }
}
