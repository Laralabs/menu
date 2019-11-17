<nav class="{{ $navClass ?: 'navbar navbar-default' }}" role="{{ $navRole ?: 'navigation' }}">
    <ul class="{{ $ulClass ?: 'sidebar-menu' }}">
        @foreach($menu->getData()->getGroups() as $group)
            @if($group->shouldShowGroupName())
                <li class="group-name">
                    {{ ucwords($group->getName()) }}
                </li>
            @endif
            @foreach($group->getItems() as $item)
                <li class="clearfix {{ $item->hasSubItems() ? 'treeview' : '' }} {{ $item->isActive() ? 'active' : '' }}">
                    <a href="{!! $item->getUrl() !!}">
                        <i class="{{ $item->getIcon() }}"></i>
                        <span>{{ $item->getName() }}</span>
                        @if($item->hasSubItems())
                            <i class="pull-right {{ $item->getToggleIcon() }}"></i>
                        @endif
                    </a>
                    @if($item->hasSubItems())
                        <ul class="treeview-menu">
                            @foreach($item->getSubItems() as $subItem)
                                <li class="clearfix {{ $subItem->isActive() ? 'active' : '' }}">
                                    <a href="{!! $subItem->getUrl() !!}">
                                        <i class="{{ $subItem->getIcon() }}"></i>
                                        <span>{{ $subItem->getName() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endforeach
    </ul>
</nav>
