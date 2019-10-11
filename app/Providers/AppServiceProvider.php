<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Components
        $general = 'project_views.components.general.';
        $mdc = 'project_views.components.mdc.';
        $custom = 'project_views.components.custom.';
        $users = 'project_views.components.users.';
        $account='project_views.components.account.';
        $parents='project_views.components.parents.';
        $teachers='project_views.components.teachers.';

        $components = [
            'general' => $general . 'general',
            'tab' => $mdc . 'tab',
            'tab_indicator' => $mdc . 'tab_indicator',
            'drawer' => $mdc . 'drawer',
            'list' => $mdc . 'list',
            'list_item' => $mdc . 'list_item',
            'list_subheader' => $mdc . 'list_subheader',
            'list_group' => $mdc . 'list_group',
            'main_content_container__inner' => $custom . 'main_content_container__inner',
            'view_users' => $users . 'view_users',
            'table_data' => $mdc . 'table_data',
            'table_head_cell' => $mdc . 'table_head_cell',
            'container' => $custom . 'container',
            'text_field_container' => $custom . 'text_field_container',
            'select_container' => $custom . 'select_container',
            'button'=>$mdc.'button',
            'users'=>$users.'users',
            'account'=>$account.'account',
            'parents'=>$parents.'parents',
            'teachers'=>$teachers.'teachers',
        ];

        foreach ($components as $component => $path) {
            Blade::component($path, $component);
        }
    }
}
