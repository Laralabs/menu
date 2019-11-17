<?php

namespace Laralabs\Menu\Contracts;

use Closure;

interface MenuExtender
{
    public function handle(Menu $menu, Closure $next);
}
