<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Tugas JQuery - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
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

        .image-checkbox{
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            outline: 0;
        }

        .image-checkbox input[type="checkbox"]{
            display: none;
        }

        .image-checkbox-checked{
            border-color: #4286f4;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
@yield('script')