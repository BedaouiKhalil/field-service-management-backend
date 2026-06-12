<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">FSM</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a class="sidebar-link"  href="{{route('admin.customers.index')}}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Customer</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link"  href="{{route('admin.tasks.index')}}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Task</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link"  href="{{route('admin.users.index')}}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">User</span>
                </a>
            </li>


        </ul>

    </div>
</nav>
