<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\MenuData;

class MenuTest extends TestCase
{
    /**
     * @var MenuData
     */
    protected $data;

    public function setUp(): void
    {
        parent::setUp();

        $this->data = $this->app->make(MenuData::class);
    }

    /** @test */
    public function it_can_add_a_new_group(): void
    {
        $group = app(Group::class);
        $group = $group->name('test');
        $this->data->addGroup($group);

        $this->assertEquals('test', $group->getName());
        $this->assertEquals(0, $group->getOrder());
        $this->assertTrue($this->data->getGroups()->contains($group));
    }

    /** @test */
    public function it_can_add_a_new_group_and_apply_callback(): void
    {
        $group = $this->data->group('test', function (Group $group) {
            $this->assertEquals('test', $group->getName());
            $group->name('test2');
            $group->order(10);

            return $group;
        });

        $this->assertEquals('test2', $group->getName());
        $this->assertEquals(10, $group->getOrder());
        $this->assertTrue($this->data->getGroups()->contains($group));
    }
}
