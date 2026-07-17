<header class="admin-header">

    <div class="header-left">

        <button class="sidebar-toggle" id="sidebarToggle">

            <i class="bi bi-list"></i>

        </button>

        <div class="page-title">

            <h5 class="mb-0">

                @yield('title', 'Dashboard')

            </h5>

        </div>

    </div>

    <div class="header-right">

        {{-- Search --}}
        <div class="header-search">

            <div class="input-group">

                <span class="input-group-text">

                    <i class="bi bi-search"></i>

                </span>

                <input type="text"
                    class="form-control"
                    placeholder="Search...">

            </div>

        </div>

        {{-- Notifications --}}
        <div class="dropdown">

            <button class="header-icon"
                data-bs-toggle="dropdown">

                <i class="bi bi-bell"></i>

                <span class="badge bg-danger">0</span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>

                    <h6 class="dropdown-header">

                        Notifications

                    </h6>

                </li>

                <li>

                    <span class="dropdown-item-text text-muted">

                        No notifications found

                    </span>

                </li>

            </ul>

        </div>

        {{-- Profile --}}
        <div class="dropdown">

            <button
                class="profile-btn"
                data-bs-toggle="dropdown">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name) }}&background=0D6EFD&color=fff"
                    alt="Profile">

                <div>

                    <strong>

                        {{ auth('admin')->user()->name }}

                    </strong>

                    <small>

                        {{ ucfirst(auth('admin')->user()->role->role_name) }}

                    </small>

                </div>

                <i class="bi bi-chevron-down"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>

                    <a
                        href="#"
                        class="dropdown-item">

                        <i class="bi bi-person"></i>

                        My Profile

                    </a>

                </li>

                <li>

                    <a
                        href="#"
                        class="dropdown-item">

                        <i class="bi bi-gear"></i>

                        Settings

                    </a>

                </li>

                <li>

                    <hr class="dropdown-divider">

                </li>

                <li>

                    <form
                        action="{{ route('admin.logout') }}"
                        method="POST">

                        @csrf

                        <button
                            class="dropdown-item text-danger">

                            <i class="bi bi-box-arrow-right"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</header>