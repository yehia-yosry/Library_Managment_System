<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Bookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="{{ session('theme','dark') == 'light' ? 'theme-light' : '' }}">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.books.index') }}">
            <img src="/images/logo.svg" height="30" alt="Admin" style="margin-right:10px">
            <span class="brand-text">Admin</span>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link theme-toggle" href="{{ route('theme.toggle') }}">Toggle Theme</a></li>
                @if(session('admin_username'))
                    <li class="nav-item"><span class="nav-link">Hello, <strong>{{ session('admin_username') }}</strong></span></li>
                @endif
                <li class="nav-item"><form method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn btn-sm btn-outline-light">Logout</button></form></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    @yield('content')
</div>
</body>
</html>