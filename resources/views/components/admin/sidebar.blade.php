<aside class="admin-sidebar" id="adminSidebar">

    {{-- Logo --}}
    <div class="sidebar-brand">

        <a href="{{ route('admin.dashboard') }}">

            <img src="{{ asset('assets/common/images/logo.png') }}"
                 alt="Logo"
                 class="sidebar-logo">

            <!-- <span>{{ config('app.name') }}</span> -->

        </a>

    </div>

    {{-- User Info --}}
    <div class="sidebar-user">

        <div class="user-avatar">

            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name) }}&background=0D6EFD&color=fff">

        </div>

        <div class="user-info">

            <h6>{{ auth('admin')->user()->name }}</h6>

            <small>{{ auth('admin')->user()->role->role_name }}</small>

        </div>

    </div>

    {{-- Navigation --}}
    <nav class="sidebar-menu">

        <ul>

            {{-- Dashboard --}}
            <li>

                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard</span>

                </a>

            </li>

            {{-- Website --}}
            <li class="menu-title">

                Website

            </li>

            <li>

                <a href="#websiteMenu"
                   data-bs-toggle="collapse">

                    <i class="bi bi-globe"></i>

                    <span>Website Management</span>

                    <i class="bi bi-chevron-down ms-auto"></i>

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
            <li class="menu-title">

                Academic

            </li>

            <li>

                <a href="#academicMenu"
                   data-bs-toggle="collapse">

                    <i class="bi bi-mortarboard"></i>

                    <span>Academic Management</span>

                    <i class="bi bi-chevron-down ms-auto"></i>

                </a>

                <ul class="collapse" id="academicMenu">
                    <li>
                        <a href="{{ route('admin.academic.index') }}">
                            <i class="bi bi-calendar3 me-2"></i> 
                            <span>Academic Session </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('admin.classes.index')}}">
                            <i class="bi bi-building me-2"></i> 
                            <span>Classes </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('admin.sections.index')}}">
                            <i class="bi bi-diagram-3 me-2"></i> 
                            <span> Sections </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.class-sections.index') }}">
                            <i class="bi bi-diagram-2 me-2"></i> 
                            <span>Class Sections </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.subjects.index') }}">
                            <i class="bi bi-book me-2"></i> 
                            <span> Subjects </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.clsubject.index') }}">
                            <i class="bi bi-journal-bookmark me-2"></i> 
                            <span>Class Subjects </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.teachers.index') }}">
                            <i class="bi bi-person-workspace me-2"></i> 
                            <span> Teachers </span>
                        </a>
                    </li>

                     <li>
                        <a href="{{ route('admin.teacher-subject.index') }}">
                            <i class="bi bi-person-video2 me-2"></i> 
                            <span>Teacher Subjects </span>
                        </a>
                    </li>

                </ul>

            </li>

            {{-- Students --}}
            <li>

                <a href="#studentMenu"
                   data-bs-toggle="collapse">

                    <i class="bi bi-people"></i>

                    <span>Students Management</span>

                    <i class="bi bi-chevron-down ms-auto"></i>

                </a>

                <ul class="collapse" id="studentMenu">

                    <li><a href="{{ route('admin.students.index') }}"><i class="bi bi-list-ul me-2"></i> <span>Student List </span></a></li>
                    <li><a href="{{ route('admin.student-promotions.index') }}"><i class="bi bi-mortarboard-fill me-2"></i> <span>Student Promotion </span></a></li>
                    

                    <li><a href="#"><i class="bi bi-person-plus me-2"></i> <span>Admissions </span></a></li>

                    <li><a href="{{ route('admin.attendance.index') }}"><i class="bi bi-calendar-check me-2"></i> <span>Attendance </span></a></li>

                </ul>

            </li>

            {{-- Exam --}}
            <li>

                <a href="#examMenu"
                   data-bs-toggle="collapse">

                    <i class="bi bi-journal-check"></i>

                    <span>Examinations</span>

                    <i class="bi bi-chevron-down ms-auto"></i>

                </a>

                <ul class="collapse" id="examMenu">

                    <li><a href="#"><i class="bi bi-journal-text me-2"></i> <span>Exams </span></a></li>

                    <li><a href="#"> <i class="bi bi-patch-question me-2"></i> <span>Questions </span></a></li>

                    <li><a href="#"> <i class="bi bi-award me-2"></i> <span>Results </span></a></li>

                </ul>

            </li>

            {{-- Users --}}
            <li class="menu-title">

                Administration

            </li>

            <li>

                <a href="#userMenu"
                   data-bs-toggle="collapse">

                    <i class="bi bi-shield-lock"></i>

                    <span>User Management</span>

                    <i class="bi bi-chevron-down ms-auto"></i>

                </a>

                <ul class="collapse" id="userMenu">
                    <li>
                        <a href="{{ route('admin.roles.index') }}">
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
                        <a href="{{ route('admin.staffs.index')}}">
                            <i class="bi bi-person-gear me-2"></i> 
                            <span> Admin Users </span>
                        </a>
                    </li>
                </ul>

            </li>

            {{-- Reports --}}
            <li>

                <a href="#">

                    <i class="bi bi-bar-chart"></i>

                    <span>Reports</span>

                </a>

            </li>

            {{-- Settings --}}
            <li>

                <a href="#">

                    <i class="bi bi-gear"></i>

                    <span>Settings</span>

                </a>

            </li>

        </ul>

    </nav>

</aside>