<!DOCTYPE html>
<html lang="en">
 @include('dashboard::layout.head')
<body>
@include('dashboard::layout.sidebar')
<div class="content">
    @include('dashboard::layout.header')
    @include('dashboard::layout.breadcrumb')
    <div class="main-content">
        @yield('content')
    </div>
</div>
</body>
@include('dashboard::layout.foot')
</html>
