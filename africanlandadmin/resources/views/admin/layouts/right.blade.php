<aside id="minileftbar" class="minileftbar">
    <ul class="menu_list">
        <li>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('public/admin/images/logo.svg') }}" alt="Alpino">
            </a>
        </li>

        <li class="power">
            @if ($adminLogin)                
            <a href="{{ route('sitesetting') }}" class=""><i class="zmdi zmdi-settings zmdi-hc-spin"></i></a>
            @endif
            <a href="{{ route('adminprofile') }}" class=""><i class="material-icons">perm_identity</i></a>

            <a href="{{ route('adminlogout') }}" title="logout" class="mega-menu"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="zmdi zmdi-power"></i>
            </a>
            <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</aside>