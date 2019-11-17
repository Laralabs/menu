<?php

namespace Laralabs\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;

interface Group
{
    public function getName(): string;

    public function name(string $name): Group;

    public function order(int $order): Group;

    public function getOrder(): int;

    public function hideGroupName(bool $hide = true): Group;

    public function shouldShowGroupName(): bool;

    public function item(string $name, ?Closure $callback = null): Item;

    public function addItem(Item $item): Group;

    public function getItems(): Collection;
}
