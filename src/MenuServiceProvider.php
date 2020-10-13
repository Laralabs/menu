<?php

namespace Laralabs\Menu;

use Illuminate\Support\ServiceProvider;
use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Contracts\MenuData;
use Laralabs\Menu\Contracts\SubItem;
use Laralabs\Menu\Models\BaseGroup;
use Laralabs\Menu\Models\BaseItem;
use Laralabs\Menu\Models\BaseMenuData;
use Laralabs\Menu\Models\BaseSubItem;

class MenuServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->app->singleton(MenuManager::class);

        $this->bindModels();

        $this->registerConfigDefinedMenus();
    }

    public function boot(): void
    {
        $this->registerViews();
    }

    protected function bindModels(): void
    {
        $this->app->bind(MenuData::class, BaseMenuData::class);
        $this->app->bind(Group::class, BaseGroup::class);
        $this->app->bind(Item::class, BaseItem::class);
        $this->app->bind(SubItem::class, BaseSubItem::class);
    }

    protected function registerConfigDefinedMenus(): void
    {
        $menus = config('laralabs-menu.menus');

        if (is_array($menus) === false) {
            return;
        }

        $manager = app(MenuManager::class);

        foreach ($menus as $menuClass) {
            $manager->register($menuClass);
        }
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laralabs-menu.php',
            'laralabs-menu'
        );

        $this->publishes([
            __DIR__.'/../config/laralabs-menu.php'  => config_path('laralabs-menu.php'),
        ], 'laralabs-menu-config');
    }

    protected function registerViews(): void
    {
        $location = __DIR__.'/../resources/views';

        $this->loadViewsFrom($location, 'laralabs-menu');

        $this->publishes([
            $location => base_path('resources/views/vendor/laralabs-menu'),
        ], 'laralabs-menu-views');
    }
}
