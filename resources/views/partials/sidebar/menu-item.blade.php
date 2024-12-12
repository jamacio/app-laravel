@inject('sidebarItemHelper', 'App\Helpers\SidebarItemHelper')

@if ($sidebarItemHelper->isHeader($item))

{{-- Header --}}
@include('partials.sidebar.menu-item-header')

@elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))

{{-- Search form --}}
@include('partials.sidebar.menu-item-search-form')

@elseif ($sidebarItemHelper->isMenuSearch($item))

{{-- Search menu --}}
@include('partials.sidebar.menu-item-search-menu')

@elseif ($sidebarItemHelper->isSubmenu($item))

{{-- Treeview menu --}}
@include('partials.sidebar.menu-item-treeview-menu')

@elseif ($sidebarItemHelper->isLink($item))

{{-- Link --}}
@include('partials.sidebar.menu-item-link')

@endif