<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
        <div class="user-profile px-10 py-15">
            <div class="d-flex align-items-center">
                <div class="image">
                    <img src={{ asset('assets/images/avatar/blank.png') }} class="avatar avatar-lg" alt="User Image">
                </div>
                <div class="info ml-10">
                    <p class="mb-0">Welcome</p>
                    @if ($currentUser['name'] != '')
                        <h5 class="mb-0">{{ explode(' ', $currentUser['name'])[0] }}</h5>
                    @endif

                </div>
            </div>
        </div>
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            @foreach ($menus as $menu)
                @if ($menu['dropdown'])
                    <li dd-d='{{ $menu['page'] }}' class='{{ $menu['page'] == Request::path() ? 'active treeview' : 'treeview' }}'>
                        <a href="#">
                            <i class="{{ $menu['icon'] }}"></i>
                            <span>{{ $menu['name'] }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @foreach ($menu['dropdown'] as $drop)
                                <li class='{{ $drop['page'] == Request::path() ? 'active treeview' : '' }}'><a href={{ $drop['link'] }}><i class="ti-more"></i>{{ $drop['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class='{{ $menu['page'] == Request::path() ? 'active' : '' }}'>
                        <a href={{ $menu['link'] }}>
                            <i class="{{ $menu['icon'] }}"></i>
                            <span>{{ $menu['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </section>
    {{-- <div class="sidebar-footer">
        <a href={{ url('profile') }} class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i>
        </a>
        <a href="#" class="link" data-toggle="tooltip" title="" data-original-title="Email">
            <i class="ti-email"></i>
        </a>
        <a href="{{ url('logout') }}" class="link" data-toggle="tooltip" title="" data-original-title="Logout">
            <i class="ti-lock"></i>
        </a>
    </div> --}}
</aside>
