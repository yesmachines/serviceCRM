@php($pageUser = auth()->user())
@if (isset($item['text'], $item['submenu']) && is_array($item['submenu']))
{{-- Treeview menu --}}
@if(isAllowedUser($item,$pageUser))
@php($active = isActiveUrl($item))
<li class="side-nav-item {{$active?'menuitem-active':''}}">
    {{-- Menu toggler --}}
    <a data-bs-toggle="collapse" href="#sidebarPages{{$ki}}" aria-expanded="false" aria-controls="sidebarPages{{$ki}}" class="side-nav-link">
        <i class="{{ $item['icon'] ?? 'ri-pages-line' }}"></i>
        <span> {{ $item['text'] }} </span>
        <span class="menu-arrow"></span>
    </a>
    {{-- Menu items --}}
    <div class="collapse {{$active?'show':''}}" id="sidebarPages{{$ki}}">
        <ul class="side-nav-second-level">
            @foreach($item['submenu'] as $item)
            <li class="{{isActiveUrl($item)?'active':''}}">
                <a href="{{ isset($item['url']) ? url($item['url']) : route($item['route']) }}">{{ $item['text'] }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</li>
@endif

@elseif (isset($item['text']) && (isset($item['url']) || isset($item['route'])))
{{-- Link --}}
@if(isAllowedUser($item,$pageUser))
<li class="side-nav-item {{isActiveUrl($item)?'menuitem-active':''}}">
    <a href="{{ isset($item['url']) ? url($item['url']) : route($item['route']) }}" class="side-nav-link">
        <i class="{{ $item['icon'] ?? 'ri-pages-line' }}"></i>
        <span> {{ $item['text'] }} </span>
    </a>
</li>
@endif
@endif