<?php

namespace Laralabs\Menu;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use Laralabs\Menu\Contracts\Menu;
use Laralabs\Menu\Exceptions\MenuNotFoundException;

class MenuManager
{
    /**
     * @var array
     */
    private $menus = [];

    /**
     * @var Collection|[]
     */
    public $resolvedMenus;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var MenuResolver
     */
    private $resolver;

    public function __construct(Container $container, MenuResolver $resolver)
    {
        $this->container = $container;
        $this->resolver = $resolver;
    }

    public function register(string $menu): self
    {
        if (class_exists($menu) === false) {
            throw new MenuNotFoundException('Menu of the class (' . $menu . ') does not exist.');
        }

        $this->menus[] = $menu;

        return $this;
    }

    public function resolve(): void
    {
        $this->resolvedMenus = [];

        $this->loadConfigMenus();

        foreach ($this->menus as $name) {
            $menu = $this->resolver->resolve($name);
            $this->resolvedMenus[$menu->name] = $menu;

            $this->container->singleton($name, static function () use ($menu) {
                return $menu;
            });
        }

        $this->resolvedMenus = collect($this->resolvedMenus);
    }

    public function getMenus(): array
    {
        return $this->menus;
    }

    public function getResolvedMenus(): Collection
    {
        return $this->resolvedMenus;
    }

    public function getResolvedMenu(string $name): ?Menu
    {
        if ($this->getResolvedMenus()->has($name) === false) {
            return null;
        }

        return $this->getResolvedMenus()->get($name);
    }

    private function loadConfigMenus(): void
    {
        $configMenus = config('laralabs-menu.menus');

        if (config($configMenus) > 0) {
            $this->menus = array_merge($configMenus, $this->menus);
        }
    }
}
