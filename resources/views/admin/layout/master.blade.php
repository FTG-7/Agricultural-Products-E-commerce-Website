<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @include('admin.layout.style')
</head>

<body>
    @include('admin.layout.menu')

    @yield('content')

    @include('admin.layout.footer')

   
</body>

</html>
@include('admin.layout.script')