<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\MenuData;

class GroupTest extends TestCase
{
    /**
     * @var Menu
     */
    protected $menu;

    public function setUp(): void
    {
        parent::setUp();

        $this->menu = $this->setupMenuWithGroup();
    }

    /** @test */
    public function it_can_add_a_new_item_to_the_group(): void
    {
        $group = $this->menu->getGroups()->first();
        $item = app(Item::class);
        $item->name('test-item');

        $group->addItem($item);

        $this->assertEquals('test-item', $group->getItems()->first()->getName());
        $this->assertTrue($group->getItems()->contains($item));
    }

    /** @test */
    public function it_can_add_a_new_item_to_the_group_and_apply_callback(): void
    {
        $item = $this->menu->getGroups()->first()->item('test-item', function (Item $item) {
            $this->assertEquals('test-item', $item->getName());
            $item->name('test-item2');
            $item->order(60);

            return $item;
        });

        $this->assertEquals('test-item2', $item->getName());
        $this->assertEquals(60, $item->getOrder());
        $this->assertTrue($this->menu->getGroups()->first()->getItems()->contains($item));
    }

    private function setupMenuWithGroup(): MenuData
    {
        $menu = $this->app->make(MenuData::class);
        $menu->group('test');

        return $menu;
    }
}
