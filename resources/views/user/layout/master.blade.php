<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @include('user.layout.style')
</head>

<body>
    @include('user.layout.menu')

    @yield('content')

    @include('user.layout.footer')

   
</body>

</html>
@include('user.layout.script')