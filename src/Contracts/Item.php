<?php

namespace Laralabs\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;

interface Item
{
    public function getName(): string;

    public function name(string $name): self;

    public function order(int $order): self;

    public function getOrder(): int;

    public function icon(string $icon): self;

    public function getIcon(): string;

    public function toggleIcon(string $toggleIcon): self;

    public function getToggleIcon(): string;

    public function url(string $url): self;

    public function getUrl(): string;

    public function route(string $routeName, $params = []): self;

    public function getItemClass(): string;

    public function subItem(string $itemName, Closure $callback = null): SubItem;

    public function addSubItem(SubItem $subItem): self;

    public function hasSubItems(): bool;

    public function getSubItems(): Collection;

    public function isActive(): bool;
}
