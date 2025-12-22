<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h1>Admin Dashboard</h1>

    <!-- Display success/error messages -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{!! session('error') !!}</p>
    @endif

    <h2>Menu</h2>
    <ul>
        <li><a href="{{ route('admin.books.create') }}">Add New Book</a></li>
        <li><a href="{{ route('admin.books.search') }}">Modify Existing Books</a></li>
        <li><a href="{{ route('admin.orders.list') }}">Confirm Orders</a></li>
        <li><a href="{{ route('admin.books.search.general') }}">Search for Books</a></li>
        <li><a href="{{ route('admin.reports.menu') }}">System Reports</a></li>
    </ul>
</body>

</html>