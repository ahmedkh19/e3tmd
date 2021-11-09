{{-- For submenu --}}
<ul class="menu-content">
  @if(isset($menu))
  @foreach($menu as $submenu)
      @if (isset($submenu->permission))
        @can($submenu->permission)
  <li class="{{ $submenu->slug === Route::currentRouteName() ? 'active' : '' }}">
    <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
      @if(isset($submenu->icon))
      <i data-feather="{{$submenu->icon}}"></i>
      @endif
      <span class="menu-item text-truncate">{{ __('data.'.$submenu->name) }}</span>
    </a>
    @if (isset($submenu->submenu))
    @include('panels/submenu', ['menu' => $submenu->submenu])
    @endif
  </li>
      @endcan
      @endif


        @if (!isset($submenu->permission))
            <li class="{{ $submenu->slug === Route::currentRouteName() ? 'active' : '' }}">
              <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
                @if(isset($submenu->icon))
                  <i data-feather="{{$submenu->icon}}"></i>
                @endif
                <span class="menu-item text-truncate">{{ __('data.'.$submenu->name) }}</span>
              </a>
              @if (isset($submenu->submenu))
                @include('panels/submenu', ['menu' => $submenu->submenu])
              @endif
            </li>
        @endif

    @endforeach
  @endif
</ul>
