<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Tablar CSS --}}
    <link rel="icon" href="{{asset(config('tablar.custom.logo.path'))}}" type="image/x-icon"/>

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('tablar.title_prefix', ''))
        @yield('title', config('tablar.title', 'Tablar'))
        @yield('title_postfix', config('tablar.title_postfix', ''))
    </title>
    <title>Dashboard</title>
    <!-- CSS files -->
    @vite('resources/js/app.js')
    {{-- Custom Stylesheets (post Tablar) --}}
    @yield('tablar_css')
</head>
<body class="@yield('classes_body')" @yield('body_data')>
@yield('body')
@yield('tablar_js')
</body>
</html>
