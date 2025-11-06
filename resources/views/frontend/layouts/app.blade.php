<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Market - Auto Parts')</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/footer.css') }}">

  <!-- Page-specific styles -->
  @yield('style')
</head>
<body>

  {{-- ✅ HEADER / TOP BAR --}}
  @include('frontend.components.header')

  {{-- ✅ MAIN PAGE CONTENT --}}
  <main>
    @yield('content')
  </main>

  {{-- ✅ FOOTER --}}
  @include('frontend.components.footer')

  {{-- ✅ SCRIPTS --}}
  @yield('scripts')
</body>
</html>
