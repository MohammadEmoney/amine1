<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title', 'آموزشگاه امین 1 - ' . config('app.name', ''))</title>
    <link rel="shortcut icon" type="image/png" href="/panel/src/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@latest/dist/css/persian-datepicker.min.css">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="/panel/src/assets/css/styles.min.css" />
    <link rel="stylesheet" href="/panel/src/assets/libs/select2/select2.min.css" />
    {{-- <link rel="stylesheet" href="/panel/src/assets/css/bootstrap.rtl.css" /> --}}
    <link rel="stylesheet" href="/panel/src/assets/css/custom.css" />
    @livewireStyles
    @stack('styles')
</head>
