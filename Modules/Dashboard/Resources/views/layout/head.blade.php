<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>Panel</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="/panel/sweetalert/sweetalert2.css">
    <link rel="stylesheet" href="/panel/css/style.css?v={{ uniqid() }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="/panel/css/responsive_991.css" media="(max-width:991px)">
    <link rel="stylesheet" href="/panel/css/responsive_768.css" media="(max-width:768px)">
    <link rel="stylesheet" href="/panel/css/font.css">
    @yield('css')
</head>
