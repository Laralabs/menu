<?php

namespace Laralabs\Menu\Models;

use Laralabs\Menu\Contracts\SubItem;
use Laralabs\Menu\Traits\CallableTrait;

class BaseSubItem implements SubItem
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
    protected $itemClass = '';

    /**
     * @var string
     */
    protected $url = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function name(string $name): SubItem
    {
        $this->name = $name;

        return $this;
    }

    public function order(int $order): SubItem
    {
        $this->order = $order;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function icon(string $icon): SubItem
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function url(string $url): SubItem
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function route(string $routeName, $params = []): SubItem
    {
        $this->url = route($routeName, $params);

        return $this;
    }

    public function getItemClass(): string
    {
        return $this->itemClass;
    }

    public function isActive(): bool
    {
        return url()->full() === $this->getUrl();
    }
}
