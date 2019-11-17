<?php

namespace Laralabs\Menu\Middleware;

use Closure;
use Laralabs\Menu\MenuManager;

class ResolveMenus
{
    /**
     * @var MenuManager
     */
    protected $manager;

    public function __construct(MenuManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle($request, Closure $next)
    {
        $this->manager->resolve();

        return $next($request);
    }
}
