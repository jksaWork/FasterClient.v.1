<div class="dlabnav" style="top: 60px">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }} ">
                <a class="ai-icon d-flex justify-content-between align-items-center"  href="/" aria-expanded="false">
                    <span>
                    <i class="la la-calendar"></i>
                    <span class="nav-text mx-2">{{__('translation.dashboard')}}</span>
                    </span>
                    <i class="la la-angle-left"></i>
                </a>
            </li>
            <li class="{{ request()->routeIs('analytics') ? 'mm-active' : '' }}" >
                <a class="ai-icon d-flex justify-content-between align-items-center"  href="{{ route('analytics')}}" aria-expanded="false">
                    <span>
                        <i class="la la-signal"></i>
                        <span class=" nav-text mx-2">{{ __('translation.analytics')}}</span>
                    </span>
                    <i class="la la-angle-left"></i>
                </a>
            </li>
            <li class="{{ request()->routeIs('addOrder') ? 'mm-active' : '' }}" >
                <a class="ai-icon d-flex justify-content-between align-items-center"  href="{{ route('addOrder')}}" aria-expanded="false">
                    <span>
                        <i class="la la-plus-circle"></i>
                        <span class="nav-text mx-2">{{__('translation.add.order')}}</span>
                    </span>
                    <i class="la la-angle-left"></i>
                </a>
            </li>
            <li class="{{ request()->routeIs('OrderHistory') ? 'mm-active' : '' }}" >
                <a class="ai-icon d-flex justify-content-between align-items-center"  href="{{ route('OrderHistory') }}" aria-expanded="false">
                    <span>
                        <i class="la la-table"></i>
                        <span class="nav-text mx-2">{{ __('translation.order-history') }}</span>
                    </span>
                    <i class="la la-angle-left"></i>
                </a>
            </li>
            <li class="{{ request()->routeIs('orderTraking') ? 'mm-active' : '' }}" >
                <a class="ai-icon d-flex justify-content-between align-items-center"  href="{{ route('orderTraking') }}" aria-expanded="false">
                    <span>
                        <i class="la la-signal"></i>
                <span class=" nav-text mx-2">{{ __('translation.order-traking')}}</span>
            </span>
                    <i class="la la-angle-left"></i>
                </a>
            </li>
            <li></li>
            </ul>
    </div>
</div>
