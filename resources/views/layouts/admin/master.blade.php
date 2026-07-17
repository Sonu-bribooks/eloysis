<!DOCTYPE html>
<html lang="en">

@include('components.admin.head')

<body>

    @include('components.common.loader')

    <div class="admin-wrapper">

        {{-- Sidebar --}}
        @include('components.admin.sidebar')

        {{-- Main Content --}}
        <div class="main-wrapper">

            {{-- Header --}}
            @include('components.admin.header')

            <main class="content-wrapper">

                <div class="container-fluid">

                    {{-- Breadcrumb --}}
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @else
                        <x-ui.breadcrumb />
                    @endif

                    {{-- Flash Message --}}
                    @include('components.common.flash-message')

                    {{-- Page Content --}}
                    @yield('content')

                </div>

            </main>

            {{-- Footer --}}
            @include('components.admin.footer')

        </div>

    </div>

    @include('components.admin.scripts')

    @stack('scripts')

</body>

</html>