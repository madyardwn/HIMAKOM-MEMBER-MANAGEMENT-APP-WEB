<div class="nav-item dropdown">
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url('{{ Auth()->user()->picture }}')"></span>
        <div class="d-none d-lg-block px-2">
            <div>
                {{ strlen(Auth()->user()->name) > 11 ? substr(Auth()->user()->name, 0, 11) . '...' : Auth()->user()->name }}
                ({{ strlen(Auth()->user()->roles->first()->name) > 11? substr(Auth()->user()->roles->first()->name,0,11) . '...': Auth()->user()->roles->first()->name }})
            </div>
            <div class="mt-1 small text-muted">{{ Auth()->user()->email }}</div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">

        @php($logout_url = View::getSection('logout_url') ?? config('tablar.logout_url', 'logout'))
        @php($profile_url = View::getSection('profile_url') ?? config('tablar.profile_url', 'logout'))
        @php($setting_url = View::getSection('setting_url') ?? config('tablar.setting_url', 'home'))

        @if (config('tablar.use_route_url', true))
            @php($profile_url = $profile_url ? route($profile_url) : '')
            @php($logout_url = $logout_url ? route($logout_url) : '')
            @php($setting_url = $setting_url ? route($setting_url) : '')
        @else
            @php($profile_url = $profile_url ? url($profile_url) : '')
            @php($logout_url = $logout_url ? url($logout_url) : '')
            @php($setting_url = $setting_url ? url($setting_url) : '')
        @endif

        <div class="d-lg-none px-3 py-3">
            <div>{{ Auth()->user()->name }}</div>
            <div class="mt-1 small text-muted">{{ Auth()->user()->email }}</div>
            <div class="mt-1 small text-muted"><span class="badge bg-blue-lt">{{ Auth()->user()->roles->first()->name }}</span></div>
        </div>

        {{-- <a href="#" class="dropdown-item">Status</a> --}}
        <a href="{{ $profile_url }}" class="dropdown-item">Profile</a>
        {{-- <a href="#" class="dropdown-item">Feedback</a> --}}
        <a href="{{ route('about.index') }}" class="dropdown-item">About</a>
        <a href="{{ route('complaints.index') }}" class="dropdown-item">Complaints</a>
        <div class="dropdown-divider"></div>
        {{-- <a href="{{$setting_url}}" class="dropdown-item">Settings</a> --}}
        <a class="dropdown-item" href="#" onclick="event.preventDefault(); $('#form-logout').submit();">
            <i class="fa fa-fw fa-power-off text-red"></i>
            {{ __('tablar::tablar.log_out') }}
        </a>
        <form class="dropdown-item" id="form-logout" action="{{ $logout_url }}" method="POST" style="display: none;">
            @if (config('tablar.logout_method'))
                {{ method_field(config('tablar.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
    </div>
</div>
