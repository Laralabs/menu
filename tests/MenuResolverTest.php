<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Exceptions\MenuNotFoundException;
use Laralabs\Menu\MenuManager;
use Laralabs\Menu\MenuResolver;
use Laralabs\Menu\Tests\Fakes\MenuFake;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithAllExtenders;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithExtender;
use Laralabs\Menu\Tests\Fakes\MenuInvalidFake;

class MenuResolverTest extends TestCase
{
    /**
     * @var MenuManager
     */
    protected $menuManager;

    /**
     * @var MenuResolver
     */
    protected $menuResolver;

    public function setUp(): void
    {
        parent::setUp();

        $this->menuManager = app(MenuManager::class);
        $this->menuResolver = app(MenuResolver::class);
    }

    /** @test */
    public function it_can_build_a_menu_from_the_manager(): void
    {
        $this->menuManager->register(MenuFake::class);
        $this->assertContains(MenuFake::class, $this->menuManager->getMenus());

        $menu = $this->menuResolver->resolve($this->menuManager->getMenus()[0]);

        $this->assertEquals('MenuFake', $menu->name);
        $this->assertCount(1, $menu->getData()->getGroups());
    }

    /** @test */
    public function it_can_build_a_menu_and_pipe_an_extender(): void
    {
        $this->menuManager->register(MenuFakeWithExtender::class);
        $this->assertContains(MenuFakeWithExtender::class, $this->menuManager->getMenus());

        $menu = $this->menuResolver->resolve($this->menuManager->getMenus()[0]);

        $this->assertEquals('MenuFakeWithExtender', $menu->name);
        $this->assertCount(2, $menu->getData()->getGroups());
    }

    /** @test */
    public function it_can_build_a_menu_and_pipe_two_extenders_adding_one_sub_item(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);
        $this->assertContains(MenuFakeWithAllExtenders::class, $this->menuManager->getMenus());

        $menu = $this->menuResolver->resolve($this->menuManager->getMenus()[0]);

        $this->assertEquals('MenuFakeWithAllExtenders', $menu->name);
        $this->assertCount(3, $menu->getData()->getGroups());
        $this->assertEquals('Sub Item', $menu->getData()->getGroups()->last()->getItems()->first()->getSubItems()->first()->getName());
    }

    /** @test */
    public function it_throws_an_exception_if_contract_not_implemented(): void
    {
        $this->expectException(MenuNotFoundException::class);

        $this->menuResolver->resolve(MenuInvalidFake::class);
    }
}
