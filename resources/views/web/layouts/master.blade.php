@include('web.layouts.header')

<body class="d-flex flex-column min-vh-100">

    {{-- Page Content --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('web.layouts.footer')

    {{-- CSS/JS libraries
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

    {{-- Optional: global JS/CSS
    <link href="{{ asset('web/css/stylesheet.css') }}" rel="stylesheet">
    <script src="{{ asset('web/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('web/js/jquery_custom.js') }}"></script>
    <script src="{{ asset('web/js/typed.js') }}"></script> --}}
    @yield('css')
    @yield('script')
</body>
