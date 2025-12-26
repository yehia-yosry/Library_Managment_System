<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/theme.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="{{ session('theme','dark') == 'light' ? 'theme-light' : '' }}">
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="/images/logo.svg" height="30" alt="Bookstore" style="margin-right:10px">
            <span class="brand-text">Bookstore</span>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('cart.view') }}">Cart ({{ count(session('cart', [])) }})</a></li>
                <li class="nav-item"><a class="nav-link theme-toggle" href="{{ route('theme.toggle') }}">Toggle Theme</a></li>

                @if(session('admin_id'))
                    <li class="nav-item"><span class="nav-link">Hello, <strong>{{ session('admin_username') }}</strong></span></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.books.index') }}">Admin</a></li>
                    <li class="nav-item">
                        <form method="post" action="{{ route('admin.logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-light nav-link" style="background:none; border:none; padding:0.5rem 0.75rem;">Logout</button>
                        </form>
                    </li>
                @else
                    @if(session('user_name'))
                        <li class="nav-item"><span class="nav-link">Hello, <strong>{{ session('user_name') }}</strong></span></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.login') }}">Admin Login</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>