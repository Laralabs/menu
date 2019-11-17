<?php

namespace Laralabs\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;

interface Group
{
    public function getName(): string;

    public function name(string $name): self;

    public function order(int $order): self;

    public function getOrder(): int;

    public function hideGroupName(bool $hide = true): self;

    public function shouldShowGroupName(): bool;

    public function item(string $name, ?Closure $callback = null): Item;

    public function addItem(Item $item): self;

    public function getItems(): Collection;
}
