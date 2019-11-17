<?php

namespace Laralabs\Menu\Contracts;

interface SubItem
{
    public function getName(): string;

    public function name(string $name): self;

    public function order(int $order): self;

    public function getOrder(): int;

    public function icon(string $icon): self;

    public function getIcon(): string;

    public function url(string $url): self;

    public function getUrl(): string;

    public function route(string $routeName, $params = []): self;

    public function getItemClass(): string;

    public function isActive(): bool;
}
