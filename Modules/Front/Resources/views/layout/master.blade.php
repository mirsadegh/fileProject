<!doctype html>
<html lang="fa">
@include('front::layout.head')
<body >
    @include('front::layout.header')
    @yield('content')
    @include('front::layout.footer')
    @include('front::layout.foot')
    @include('dashboard::alerts.sweetalert.success')
    @include('dashboard::alerts.sweetalert.error')
</body>
</html>
