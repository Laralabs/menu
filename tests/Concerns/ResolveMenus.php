<?php

namespace Laralabs\Menu\Tests\Concerns;

use Laralabs\Menu\MenuManager;

trait ResolveMenus
{
    public function resolveMenus(): void
    {
        if (property_exists($this, 'menuManager')) {
            $this->menuManager->resolve();

            return;
        }

        app(MenuManager::class)->resolve();
    }
}
