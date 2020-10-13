<?php

namespace Laralabs\Menu\Models;

use Closure;
use Illuminate\Support\Collection;
use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\MenuData;
use Laralabs\Menu\Traits\CallableTrait;

class BaseMenuData implements MenuData
{
    use CallableTrait;

    /**
     * @var Collection
     */
    protected $groups;

    public function __construct()
    {
        $this->groups = collect();
    }

    public function group(string $name, ?Closure $callback = null): Group
    {
        $group = $this->getOrCreateGroup($name);

        $this->call($callback, $group);

        $this->addGroup($group);

        return $group;
    }

    public function addGroup(Group $group): MenuData
    {
        $this->groups->put($group->getName(), $group);

        return $this;
    }

    public function getGroups(): Collection
    {
        return $this->groups
            ->sortBy(static function (Group $group) {
                return $group->getOrder();
            });
    }

    private function getOrCreateGroup(string $name): Group
    {
        if ($this->groups->has($name)) {
            return $this->groups->get($name);
        }

        return tap(
            app(Group::class),
            static function (Group $group) use ($name): Group {
                $group->name($name);

                return $group;
            }
        );
    }
}
