<?php

namespace Laralabs\Menu\Tests\Fakes;

use Closure;
use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\MenuExtender;

class MenuExtenderSubItemFake implements MenuExtender
{
    public function handle(Menu $menu, Closure $next)
    {
        $menu->getData()->group('groupThree', static function (Group $group) {
            $group->order(3);
            $group->item('Group Three, Item One', static function (Item $item) {
                $item->subItem('Sub Item');
            });
        });

        return $next($menu);
    }
}
