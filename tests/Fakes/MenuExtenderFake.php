<?php

namespace Laralabs\Menu\Tests\Fakes;

use Closure;
use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\MenuExtender;

class MenuExtenderFake implements MenuExtender
{
    public function handle(Menu $menu, Closure $next)
    {
        $menu->getData()->group('groupTwo', static function (Group $group) {
            $group->order(2);
            $group->item('Group Two, Item One');
        });

        return $next($menu);
    }
}
