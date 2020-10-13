<?php

namespace Laralabs\Menu\Models;

use Closure;
use Illuminate\Support\Collection;
use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Contracts\SubItem;
use Laralabs\Menu\Traits\CallableTrait;

class BaseItem implements Item
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
     * @var string
     */
    protected $icon = 'fas fa-angle-double-right';

    /**
     * @var string
     */
    protected $toggleIcon = 'fas fa-angle-down';

    /**
     * @var string
     */
    protected $itemClass = '';

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var Collection
     */
    protected $subItems;

    public function __construct()
    {
        $this->subItems = collect();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function name(string $name): Item
    {
        $this->name = $name;

        return $this;
    }

    public function order(int $order): Item
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function icon(string $icon): Item
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function toggleIcon(string $toggleIcon): Item
    {
        $this->toggleIcon = $toggleIcon;

        return $this;
    }

    public function getToggleIcon(): string
    {
        return $this->toggleIcon;
    }

    public function url(string $url): Item
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function route(string $routeName, $params = []): Item
    {
        $this->url = route($routeName, $params);

        return $this;
    }

    public function getItemClass(): string
    {
        return $this->itemClass;
    }

    public function subItem(string $itemName, Closure $callback = null): SubItem
    {
        $subItem = $this->getOrCreateSubItem($itemName);

        $this->call($callback, $subItem);

        $this->addSubItem($subItem);

        return $subItem;
    }

    public function addSubItem(SubItem $subItem): Item
    {
        $this->subItems->put($subItem->getName(), $subItem);

        return $this;
    }

    public function hasSubItems(): bool
    {
        return (bool) $this->subItems->count();
    }

    public function getSubItems(): Collection
    {
        return $this->subItems
            ->sortBy(static function (SubItem $subItem) {
                return $subItem->getOrder();
            });
    }

    public function isActive(): bool
    {
        return url()->full() === $this->getUrl();
    }

    private function getOrCreateSubItem(string $name): SubItem
    {
        if ($this->subItems->has($name)) {
            return $this->subItems->get($name);
        }

        return tap(
            app(SubItem::class),
            static function (SubItem $subItem) use ($name): SubItem {
                $subItem->name($name);

                return $subItem;
            }
        );
    }
}
