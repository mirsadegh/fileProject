<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://webamooz.net"></a>
     <x-user-photo />

    <ul>

         @foreach (config('sidebar.items') as $sidebarItem)
            {{-- {{ dd($sidebarItem) }} --}}
           {{-- {{ dd(array_key_exists('permission',$sidebarItem)) }} --}}
            @if (!array_key_exists('permission',$sidebarItem) ||
                 auth()->user()->hasPermissionTo($sidebarItem['permission']) ||
                 auth()->user()->hasPermissionTo(\Modules\RolePermission\Entities\Permission::PERMISSION_SUPER_ADMIN))
               <li class="item-li {{ $sidebarItem['icon'] }} @if(str_starts_with(request()->url(),$sidebarItem['url'] )) is-active  @endif">
                <a href="{{ $sidebarItem['url'] }}">{{ $sidebarItem['title'] }}</a>
              </li>
            @endif
         @endforeach
    </ul>

</div>
