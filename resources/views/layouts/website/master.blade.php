<!DOCTYPE html>
<html lang="en">

@include('components.website.head')

<body>

    @include('components.website.topbar')

    @include('components.website.header')

    @include('components.website.navbar')

    <main>
        
        @yield('content')

    </main>

    @include('components.website.footer')

    @include('components.website.scripts')

</body>

</html>