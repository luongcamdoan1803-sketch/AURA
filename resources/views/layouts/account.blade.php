<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Tài khoản — AURA FLORIST')
    </title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
    <!-- CSS tài khoản -->
    <link
        rel="stylesheet"
        href="{{ asset('css/account.css') }}"
    >
</head>
<body>
    <!-- NỘI DUNG TÀI KHOẢN -->
    @yield('content')
    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    @stack('scripts')
</body>
</html>