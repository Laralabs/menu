<?php

namespace Laralabs\Menu\Contracts;

interface SubItem
{
    public function getName(): string;

    public function name(string $name): SubItem;

    public function order(int $order): SubItem;

    public function getOrder(): int;

    public function icon(string $icon): SubItem;

    public function getIcon(): string;

    public function url(string $url): SubItem;

    public function getUrl(): string;

    public function route(string $routeName, $params = []): SubItem;

    public function getItemClass(): string;

    public function isActive(): bool;
}
