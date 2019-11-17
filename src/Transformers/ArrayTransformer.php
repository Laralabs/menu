<?php

namespace Laralabs\Menu\Transformers;

use Laralabs\Menu\Contracts\Group;
use Laralabs\Menu\Contracts\Item;
use Laralabs\Menu\Contracts\MenuData;
use Laralabs\Menu\Contracts\SubItem;
use Laralabs\Menu\Contracts\Transformer;

class ArrayTransformer implements Transformer
{
    public function transform(MenuData $menu): array
    {
        return $menu->getGroups()
            ->mapWithKeys(function (Group $group) {
                return $this->transformGroup($group);
            })->toArray();
    }

    private function transformGroup(Group $group): array
    {
        return [
            $group->getName() => [
                'name' => $group->shouldShowGroupName() ? $group->getName() : null,
                'order' => $group->getOrder(),
                'showName' => $group->shouldShowGroupName(),
                'items' => $group->getItems()
                    ->mapWithKeys(function (Item $item) {
                        return $this->transformItem($item);
                    })->toArray(),
            ]
        ];
    }

    private function transformItem(Item $item): array
    {
        return [
            $item->getName() => [
                'name' => $item->getName(),
                'order' => $item->getOrder(),
                'icon' => $item->getIcon(),
                'toggleIcon' => $item->getToggleIcon(),
                'itemClass' => $item->getItemClass(),
                'url' => $item->getSubItems()->count() === 0 ? $item->getUrl() : '#',
                'subItems' => $item->getSubItems()
                    ->mapWithKeys(function (SubItem $subItem) {
                        return $this->transformSubItem($subItem);
                    })->toArray(),
            ]
        ];
    }

    private function transformSubItem(SubItem $subItem): array
    {
        return [
            $subItem->getName() => [
                'name' => $subItem->getName(),
                'order' => $subItem->getOrder(),
                'icon' => $subItem->getIcon(),
                'itemClass' => $subItem->getItemClass(),
                'url' => $subItem->getUrl(),
            ]
        ];
    }
}
