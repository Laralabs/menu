<?php

namespace Laralabs\Menu\Contracts;

interface Resolver
{
    public function resolve(string $name): Menu;
}
