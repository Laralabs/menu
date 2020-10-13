<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\Exceptions\MenuNameRequiredException;
use Laralabs\Menu\Exceptions\MenuPresenterFormatterNotFound;
use Laralabs\Menu\MenuManager;
use Laralabs\Menu\MenuPresenter;
use Laralabs\Menu\Tests\Concerns\ResolveMenus;
use Laralabs\Menu\Tests\Fakes\MenuFakeWithAllExtenders;
use Spatie\Snapshots\MatchesSnapshots;

class HelperTest extends TestCase
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
    public function it_throws_an_exception_if_invalid_presenter_format_specified(): void
    {
        $this->expectException(MenuPresenterFormatterNotFound::class);

        get_menu('invalidformat');
    }

    /** @test */
    public function it_can_get_a_menu_using_the_array_presenter(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        $results = get_menu(MenuPresenter::TO_ARRAY);

        $this->assertCount(1, $results);
        $this->assertMatchesSnapshot($results);
    }

    /** @test */
    public function it_can_get_a_menu_using_the_json_presenter(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        $results = get_menu(MenuPresenter::TO_JSON);

        $this->assertTrue(is_string($results));
        $this->assertMatchesJsonSnapshot($results);
    }

    /** @test */
    public function it_can_get_a_menu_using_the_collection_presenter(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        $results = get_menu(MenuPresenter::TO_COLLECTION);

        $this->assertCount(1, $results);
        $this->assertCount(3, $results->first()->getData()->getGroups());
    }

    /** @test */
    public function it_can_get_a_menu_using_the_markup_presenter(): void
    {
        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        $results = get_menu(MenuPresenter::TO_MARKUP, $this->menuManager->getResolvedMenus()->first()->name);

        $this->assertMatchesHtmlSnapshot($results);
    }

    /** @test */
    public function it_throws_an_exception_if_using_the_markup_presenter_without_a_name(): void
    {
        $this->expectException(MenuNameRequiredException::class);

        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        get_menu(MenuPresenter::TO_MARKUP);
    }

    /** @test */
    public function it_can_get_a_menu_using_the_bootstrap_presenter(): void
    {
        $this->markTestSkipped('TODO: Implement bootstrap present with correct markup');

        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        $results = get_menu(MenuPresenter::TO_BOOTSTRAP, $this->menuManager->getResolvedMenus()->first()->name);

        $this->assertMatchesHtmlSnapshot($results);
    }

    /** @test */
    public function it_throws_an_exception_if_using_the_bootstrap_presenter_without_a_name(): void
    {
        $this->markTestSkipped('TODO: Implement bootstrap present with correct markup');

        $this->expectException(MenuNameRequiredException::class);

        $this->menuManager->register(MenuFakeWithAllExtenders::class);

        $this->resolveMenus();

        get_menu(MenuPresenter::TO_BOOTSTRAP);
    }
}
