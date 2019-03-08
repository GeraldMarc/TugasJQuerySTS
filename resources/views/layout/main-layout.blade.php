<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Tugas JQuery - @yield('title')</title>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <style>
        .clickable:hover{
            cursor: pointer;
        }
        .main-image{
            width: 150px;
            margin: 3px;
            display: block;
        }
        .product-image{
            width: 50px;
            margin: 3px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
@yield('script')