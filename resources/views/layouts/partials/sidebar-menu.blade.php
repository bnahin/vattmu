<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li class="{{ \App\Utils::checkRoute('home') ? 'active': '' }}">
        <a href="{{ route('home') }}">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="weather">
            <i class="fas fa-sun"> </i> Weather
        </a>
    </li>
    <li class="">
        <a href="pirep">
            <i class="fas fa-paper-plane"> </i> PIREPs
        </a>
    </li>
    <li class="">
        <a href="pirep">
            <i class="fas fa-exclamation-triangle"> </i> Restrictions
        </a>
    </li>
    <li class="">
        <a href="pirep">
            <i class="fas fa-plane"> </i> TMU Map
        </a>
    </li><li class="">
        <a href="pirep">
            <i class="fas fa-users"> </i> Controller Info
        </a>
    </li>
    <li class="header">ADMINISTRATION</li>
    <li class="">
        <a href="#">
                <i class="fas fa-users-cog"></i> <span>User Management</span>
            </a>
        </li>
    <li class="">
        <a href="admin">
            <i class="fas fa-cogs"> </i> Configuration
        </a>
    </li>
</ul>
