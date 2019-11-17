<?php

namespace Laralabs\Menu\Models;

use Closure;
use Illuminate\Support\Collection;
use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Traits\CallableTrait;

class BaseGroup implements Group
{
    use CallableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $order = 0;

    /**
     * @var bool
     */
    protected $showName = true;

    /**
     * @var Collection
     */
    protected $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function name(string $name): Group
    {
        $this->name = $name;

        return $this;
    }

    public function order(int $order): Group
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function hideGroupName(bool $show = false): Group
    {
        $this->showName = false;

        return $this;
    }

    public function shouldShowGroupName(): bool
    {
        return (bool) $this->showName;
    }

    public function item(string $name, ?Closure $callback = null): Item
    {
        $item = $this->getOrCreateItem($name);

        $this->call($callback, $item);

        $this->addItem($item);

        return $item;
    }

    public function addItem(Item $item): Group
    {
        $this->items->put($item->getName(), $item);

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items
            ->sortBy(static function (Item $item) {
                return $item->getOrder();
            });
    }

    private function getOrCreateItem(string $name): Item
    {
        if ($this->items->has($name)) {
            return $this->items->get($name);
        }

        return tap(
            app(Item::class),
            static function (Item $item) use ($name): Item {
                $item->name($name);

                return $item;
            });
    }
}
