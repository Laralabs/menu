<?php

namespace Laralabs\Menu\Contracts;

interface Transformer
{
    public function transform(MenuData $menu);
}
