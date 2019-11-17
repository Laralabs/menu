<?php

namespace Laralabs\Menu;

use Illuminate\Pipeline\Pipeline;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\Resolver;
use Laralabs\Menu\Exceptions\MenuNotFoundException;

class MenuResolver implements Resolver
{
    public function resolve(string $class): Menu
    {
        $menu = app($class);

        if (!$menu instanceof Menu) {
            throw new MenuNotFoundException(
                'Your menu must implement ' . Menu::class . ' interface, value given: ' . $class
            );
        }

        $menu->build();

        if ($menu->hasExtenders() === false) {
            return $menu;
        }

        return app(Pipeline::class)
            ->send($menu)
            ->through($menu->extenders())
            ->then(static function (Menu $menu) {
                return $menu;
            });
    }
}
