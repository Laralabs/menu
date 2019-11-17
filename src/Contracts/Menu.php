<?php

namespace Laralabs\Menu\Contracts;

abstract class Menu
{
    /**
     * @var Menu
     */
    protected $menu;

    public function __construct(MenuData $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Build your menu implementation here
     */
    abstract public function build(): void;

    /**
     * Add any extenders in here, they will be passed
     * through a pipe in the order they are in the array.
     *
     * If no extenders then just return an empty array.
     */
    abstract public function extenders(): array;

    /**
     * @return MenuData
     */
    public function getData(): MenuData
    {
        return $this->menu;
    }

    public function hasExtenders(): bool
    {
        return (bool) count($this->extenders());
    }
}
