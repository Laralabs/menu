<?php

namespace Laralabs\Menu\Tests\Fakes;

use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Menu;

class MenuFake extends Menu
{
    public $name = 'MenuFake';

    /**
     * Build your menu implementation here
     */
    public function build(): void
    {
        $this->menu->group('groupOne', static function (Group $group) {
            $group->order(1);
            $group->item('Group One, Item One');
        });
    }

    /**
     * Add any extenders in here, they will be passed
     * through a pipe in the order they are in the array.
     *
     * If no extenders then just return an empty array.
     */
    public function extenders(): array
    {
        return [];
    }
}
