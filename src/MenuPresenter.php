<?php

namespace Laralabs\Menu;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Contracts\MenuData;
use Laralabs\Menu\Exceptions\MenuNameRequiredException;
use Laralabs\Menu\Transformers\ArrayTransformer;

class MenuPresenter
{
    public const TO_COLLECTION = 'collection';
    public const TO_MARKUP = 'markup';
    public const TO_BOOTSTRAP = 'bootstrap';
    public const TO_ARRAY = 'array';
    public const TO_JSON = 'json';

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var MenuManager
     */
    protected $manager;

    public function __construct(Container $container, MenuManager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
    }

    public function toCollection(?string $menu = null): Collection
    {
        if ($menu === null) {
            return $this->manager->getResolvedMenus();
        }

        return $this->manager->getResolvedMenus()
            ->filter(static function (Menu $resolvedMenu) use ($menu) {
                return $resolvedMenu->name === $menu;
            });
    }

    public function toArray(?string $menu = null): array
    {
        if ($menu === null) {
            return $this->manager->getResolvedMenus()
                ->map(function (Menu $menu) {
                    return $this->arrayTransformer($menu->getData());
                })->toArray();
        }

        $menu = $this->manager->getResolvedMenu($menu);

        if ($menu === null) {
            return [];
        }

        return $this->arrayTransformer($menu->getData());
    }

    public function toJson(?string $menu = null): string
    {
        return json_encode($this->toArray($menu));
    }

//    public function toBootstrap(
//        ?string $menu = null,
//        ?string $navClass = null,
//        ?string $navRole = null,
//        ?string $ulClass = null
//    ): string {
//        if ($menu === null) {
//            throw new MenuNameRequiredException('A menu name is required for the toBootstrap() method');
//        }
//
//        return View::make('laralabs-menu::bootstrap', [
//            'menu'     => $this->toCollection($menu)->first(),
//            'navClass' => $navClass,
//            'navRole'  => $navRole,
//            'ulClass'  => $ulClass,
//        ])->render();
//    }

    public function toMarkup(
        ?string $menu = null,
        ?string $navClass = null,
        ?string $navRole = null,
        ?string $ulClass = null
    ): string {
        if ($menu === null) {
            throw new MenuNameRequiredException('A menu name is required for the toMarkup() method');
        }

        return View::make('laralabs-menu::markup', [
            'menu'     => $this->toCollection($menu)->first(),
            'navClass' => $navClass,
            'navRole'  => $navRole,
            'ulClass'  => $ulClass,
        ])->render();
    }

    private function arrayTransformer(MenuData $menu): array
    {
        return $this->container
            ->make(ArrayTransformer::class)
            ->transform($menu);
    }
}
