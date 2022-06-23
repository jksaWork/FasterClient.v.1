<div class="dlabnav" style="top: 60px">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}"><a class="ai-icon" href="/" aria-expanded="false">
                    <i class="la la-calendar"></i>
                    <span class="nav-text mx-2">{{__('translation.dashboard')}}</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('analytics') ? 'mm-active' : '' }}" ><a class="ai-icon" href="{{ route('analytics')}}" aria-expanded="false">
                <i class="la la-signal"></i>
                <span class=" nav-text mx-2">{{ __('translation.analytics')}}</span>
            </a>
            </li>
            <li class="{{ request()->routeIs('addOrder') ? 'mm-active' : '' }}" ><a class="ai-icon" href="{{route('addOrder')}}" aria-expanded="false">
                <i class="la la-desktop"></i>
                <span class="nav-text mx-2">{{__('translation.add.order')}}</span>
            </a>
            </li>
            <li class="{{ request()->routeIs('OrderHistory') ? 'mm-active' : '' }}" ><a class="ai-icon" href="{{ route('OrderHistory')}}" aria-expanded="false">
                <i class="la la-table"></i>
                <span class="nav-text mx-2">{{ __('translation.order-history') }}</span>
            </a>
            </li>
            <li class="{{ request()->routeIs('orderTraking') ? 'mm-active' : '' }}" ><a class="ai-icon" href="{{ route('orderTraking')}}" aria-expanded="false">
                <i class="la la-signal"></i>
                <span class=" nav-text mx-2">{{ __('translation.order-traking')}}</span>
            </a>
            </li>

            <li></li>
            </ul>
    </div>
</div>
