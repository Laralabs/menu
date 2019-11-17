<?php

namespace Laralabs\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;

interface Item
{
    public function getName(): string;

    public function name(string $name): Item;

    public function order(int $order): Item;

    public function getOrder(): int;

    public function icon(string $icon): Item;

    public function getIcon(): string;

    public function toggleIcon(string $toggleIcon): Item;

    public function getToggleIcon(): string;

    public function url(string $url): Item;

    public function getUrl(): string;

    public function route(string $routeName, $params = []): Item;

    public function getItemClass(): string;

    public function subItem(string $itemName, Closure $callback = null): SubItem;

    public function addSubItem(SubItem $subItem): Item;

    public function hasSubItems(): bool;

    public function getSubItems(): Collection;

    public function isActive(): bool;
}
