<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Facades\Menu;
use Laralabs\Menu\MenuManager;
use Laralabs\Menu\Tests\Concerns\ResolveMenus;
use Laralabs\Menu\Tests\Fakes\MenuFake;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithAllExtenders;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithExtender;
use Spatie\Snapshots\MatchesSnapshots;

class MenuPresenterTest extends TestCase
{
    use ResolveMenus;
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
    public function it_can_transform_all_the_menus_into_arrays_keyed_by_name(): void
    {
        $this->menuManager->register(MenuFake::class);
        $this->menuManager->register(MenuFakeWithExtender::class);
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->assertCount(3, $this->menuManager->getMenus());

        $this->resolveMenus();

        $this->assertCount(3, $this->menuManager->getResolvedMenus());
        $results = Menu::toArray();
        $this->assertCount(3, $results);
        $this->assertMatchesSnapshot($results);
    }

    /** @test */
    public function it_can_transform_all_the_menus_into_json_keyed_by_name(): void
    {
        $this->menuManager->register(MenuFake::class);
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->assertCount(2, $this->menuManager->getMenus());

        $this->resolveMenus();

        $this->assertCount(2, $this->menuManager->getResolvedMenus());
        $results = Menu::toJson();
        $this->assertMatchesJsonSnapshot($results);
    }

    /** @test */
    public function it_can_transform_all_the_menus_into_a_collection_keyed_by_name(): void
    {
        $this->menuManager->register(MenuFake::class);
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->assertCount(2, $this->menuManager->getMenus());

        $this->resolveMenus();

        $this->assertCount(2, $this->menuManager->getResolvedMenus());
        $results = Menu::toCollection();
        $this->assertCount(2, $results);
        $this->assertTrue($results->has($this->menuManager->getResolvedMenus()->first()->name));
        $this->assertTrue($results->has($this->menuManager->getResolvedMenus()->last()->name));
    }

    /** @test */
    public function it_can_transform_the_menu_into_markup(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);
        $this->assertCount(1, $this->menuManager->getMenus());

        $this->resolveMenus();

        $this->assertCount(1, $this->menuManager->getResolvedMenus());

        $results = Menu::toMarkup($this->menuManager->getResolvedMenus()->first()->name);
        $this->assertMatchesHtmlSnapshot($results);
    }

    /** @test */
    public function it_can_transform_the_menu_into_bootstrap_markup(): void
    {
        $this->markTestSkipped('TODO: Implement bootstrap presenter with correct markup');

        $this->menuManager->register(MenuFakeWithAllExtenders::class);
        $this->assertCount(1, $this->menuManager->getMenus());

        $this->resolveMenus();

        $this->assertCount(1, $this->menuManager->getResolvedMenus());

        $results = Menu::toBootstrap($this->menuManager->getResolvedMenus()->first()->name);
        $this->assertMatchesHtmlSnapshot($results);
    }
}
