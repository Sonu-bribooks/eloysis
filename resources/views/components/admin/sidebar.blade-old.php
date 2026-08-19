<aside class="admin-sidebar" id="adminSidebar">

    {{-- User Banner Card (Matching Reference Design) --}}
    <div class="sidebar-user-card">

        <div class="user-card-banner">

            <div class="user-avatar-wrapper">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name) }}&background=0284C7&color=fff"
                     alt="{{ auth('admin')->user()->name }}"
                     class="user-avatar-img">

            </div>

        </div>

        <div class="user-card-body">

            <h6 class="user-name">{{ auth('admin')->user()->name }}</h6>

            <small class="user-role">{{ ucfirst(auth('admin')->user()->role->role_name ?? 'Admin') }}</small>

        </div>

    </div>

    {{-- Navigation --}}
    <nav class="sidebar-menu">

        <ul>

            <li class="menu-title">

                NAVIGATION

            </li>

            {{-- Dashboard --}}
            <li>

                <a href="{{ route('admin.dashboard') }}"
                   title="Dashboard"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard</span>

                </a>

            </li>

            {{-- Website --}}
            <li>

                <a href="#websiteMenu"
                   title="Website Management"
                   data-bs-toggle="collapse"
                   aria-expanded="false">

                    <i class="bi bi-globe"></i>

                    <span>Website Management</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse" id="websiteMenu">
                    <li>
                        <a href="#">
                            <i class="bi bi-images me-2"></i>
                            <span> Home Slider </span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-newspaper me-2"></i>
                            <span>News</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-calendar-event me-2"></i>
                            <span>Events</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-image me-2"></i>
                            <span>Gallery</span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-envelope me-2"></i> 
                            <span>Contact Messages</span>
                        </a>
                    </li>
                </ul>

            </li>

            {{-- Academic --}}
            <li>

                <a href="#academicMenu"
                   title="Academic Management"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->is('admin/academic*') || request()->is('admin/classes*') || request()->is('admin/sections*') || request()->is('admin/subjects*') || request()->is('admin/teachers*') || request()->is('admin/clsubject*') || request()->is('admin/teacher-subject*') ? 'true' : 'false' }}">

                    <i class="bi bi-mortarboard"></i>

                    <span>Academic Management</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse {{ request()->is('admin/academic*') || request()->is('admin/classes*') || request()->is('admin/sections*') || request()->is('admin/subjects*') || request()->is('admin/teachers*') || request()->is('admin/clsubject*') || request()->is('admin/teacher-subject*') ? 'show' : '' }}" id="academicMenu">
                    <li>
                        <a href="{{ route('admin.academic.index') }}" class="{{ menu_item_active('admin.academic.index') }}">
                            <i class="bi bi-calendar3 me-2"></i> 
                            <span>Academic Session </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('admin.classes.index')}}" class="{{ menu_item_active('admin.classes.index') }}">
                            <i class="bi bi-building me-2"></i> 
                            <span>Classes </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('admin.sections.index')}}" class="{{ menu_item_active('admin.sections.index') }}">
                            <i class="bi bi-diagram-3 me-2"></i> 
                            <span> Sections </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.class-sections.index') }}" class="{{ menu_item_active('admin.class-sections.index') }}">
                            <i class="bi bi-diagram-2 me-2"></i> 
                            <span>Class Sections </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.subjects.index') }}" class="{{ menu_item_active('admin.subjects.index') }}">
                            <i class="bi bi-book me-2"></i> 
                            <span> Subjects </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.clsubject.index') }}" class="{{ menu_item_active('admin.clsubject.index') }}">
                            <i class="bi bi-journal-bookmark me-2"></i> 
                            <span>Class Subjects </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.teachers.index') }}" class="{{ menu_item_active('admin.teachers.index') }}">
                            <i class="bi bi-person-workspace me-2"></i> 
                            <span> Teachers </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.teacher-subject.index') }}" class="{{ menu_item_active('admin.teacher-subject.index') }}">
                            <i class="bi bi-person-video2 me-2"></i> 
                            <span>Teacher Subjects </span>
                        </a>
                    </li>

                </ul>

            </li>

            {{-- Students --}}
            <li>

                <a href="#studentMenu"
                   title="Students Management"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->is('admin/students*') || request()->is('admin/student-promotions*') || request()->is('admin/attendance*') ? 'true' : 'false' }}">

                    <i class="bi bi-people"></i>

                    <span>Students Management</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse {{ request()->is('admin/students*') || request()->is('admin/student-promotions*') || request()->is('admin/attendance*') ? 'show' : '' }}" id="studentMenu">

                    <li><a href="{{ route('admin.students.index') }}" class="{{ menu_item_active('admin.students.index') }}"><i class="bi bi-list-ul me-2"></i> <span>Student List </span></a></li>
                    <li><a href="{{ route('admin.student-promotions.index') }}" class="{{ menu_item_active('admin.student-promotions.index') }}"><i class="bi bi-mortarboard-fill me-2"></i> <span>Student Promotion </span></a></li>
                    
                    <li><a href="#"><i class="bi bi-person-plus me-2"></i> <span>Admissions </span></a></li>

                    <li><a href="{{ route('admin.attendance.index') }}" class="{{ menu_item_active('admin.attendance.index') }}"><i class="bi bi-calendar-check me-2"></i> <span>Attendance </span></a></li>

                </ul>

            </li>

            {{-- Exam --}}
            <li>

                <a href="#examMenu"
                   title="Examinations"
                   data-bs-toggle="collapse"
                   aria-expanded="false">

                    <i class="bi bi-journal-check"></i>

                    <span>Examinations</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse" id="examMenu">

                    <li><a href="#"><i class="bi bi-journal-text me-2"></i> <span>Exams </span></a></li>

                    <li><a href="#"> <i class="bi bi-patch-question me-2"></i> <span>Questions </span></a></li>

                    <li><a href="#"> <i class="bi bi-award me-2"></i> <span>Results </span></a></li>

                </ul>

            </li>

            {{-- Administration --}}
            <li class="menu-title">

                ADMINISTRATION

            </li>

            <li>

                <a href="#userMenu"
                   title="User Management"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->is('admin/roles*') || request()->is('admin/staffs*') ? 'true' : 'false' }}">

                    <i class="bi bi-shield-lock"></i>

                    <span>User Management</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse {{ request()->is('admin/roles*') || request()->is('admin/staffs*') ? 'show' : '' }}" id="userMenu">
                    <li>
                        <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                            <i class="bi bi-person-badge me-2"></i> 
                            <span> Roles </span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-shield-lock me-2"></i> 
                            <span> Permissions </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.staffs.index')}}" class="{{ menu_item_active('admin.staffs.index') }}">
                            <i class="bi bi-person-gear me-2"></i> 
                            <span> Admin Users </span>
                        </a>
                    </li>
                </ul>

            </li>

            {{-- Reports --}}
            <li>

                <a href="#" title="Reports">

                    <i class="bi bi-bar-chart"></i>

                    <span>Reports</span>

                </a>

            </li>

            {{-- Settings --}}
            <li>

                <a href="#" title="Settings">

                    <i class="bi bi-gear"></i>

                    <span>Settings</span>

                </a>
                <a href="#settingsMenu"
                   title="Settings"
                   data-bs-toggle="collapse"
                   aria-expanded="{{ request()->is('admin/roles*') || request()->is('admin/staffs*') ? 'true' : 'false' }}">

                    <i class="bi bi-shield-lock"></i>

                    <span>Settings</span>

                    <i class="bi bi-chevron-right ms-auto menu-chevron"></i>

                </a>

                <ul class="collapse {{ request()->is('admin/logs*') || request()->is('admin/settings*') ? 'show' : '' }}" id="settingsMenu">
                    <li>
                        <a href="{{ route('admin.logs.index') }}" class="{{ menu_item_active('admin.logs.index') }}">
                            <i class="bi bi-person-badge me-2"></i> 
                            <span> Logs </span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="bi bi-shield-lock me-2"></i> 
                            <span> Import </span>
                        </a>
                    </li>
                </ul>

            </li>

        </ul>

    </nav>

</aside>