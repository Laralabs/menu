<?php

namespace Laralabs\Menu\Facades;

use Illuminate\Support\Facades\Facade;
use Laralabs\Menu\MenuPresenter;

class Menu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MenuPresenter::class;
    }
}
