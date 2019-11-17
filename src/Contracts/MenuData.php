<?php

namespace Laralabs\Menu\Contracts;

use Closure;
use Illuminate\Support\Collection;

interface MenuData
{
    public function group(string $name, ?Closure $callback = null): Group;

    public function addGroup(Group $group): self;

    public function getGroups(): Collection;
}
