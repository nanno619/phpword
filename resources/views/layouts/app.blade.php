<!DOCTYPE html>
<html>
<head>
    <title>Your App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>