<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Exceptions\MenuNotFoundException;
use Laralabs\Menu\MenuManager;
use Laralabs\Menu\Tests\Fakes\MenuFake;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithExtender;
use Spatie\Snapshots\MatchesSnapshots;

class MenuManagerTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @var MenuManager
     */
    protected $menuManager;

    public function setUp(): void
    {
        parent::setUp();

        $this->menuManager = app(MenuManager::class);
    }

    /** @test */
    public function it_can_register_a_menu_class(): void
    {
        $this->menuManager->register(MenuFake::class);

        $this->assertContains(MenuFake::class, $this->menuManager->getMenus());
    }

    /** @test */
    public function it_can_resolve_the_menus_into_container(): void
    {
        $this->menuManager->register(MenuFake::class);
        $this->menuManager->register(MenuFakeWithExtender::class);

        $this->assertCount(2, $this->menuManager->getMenus());

        $this->menuManager->resolve();

        $this->assertCount(2, $this->menuManager->getResolvedMenus());
        $this->assertEquals($this->menuManager->getResolvedMenus()->first(), app(MenuFake::class));
        $this->assertEquals($this->menuManager->getResolvedMenus()->last(), app(MenuFakeWithExtender::class));
    }

    /** @test */
    public function it_throws_an_exception_if_menu_class_not_found(): void
    {
        $this->expectException(MenuNotFoundException::class);

        $this->menuManager->register(NonExistentMenu::class);
    }
}
