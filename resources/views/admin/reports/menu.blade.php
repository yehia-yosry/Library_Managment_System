<!DOCTYPE html>
<html>

<head>
    <title>System Reports</title>
</head>

<body>
    <h1>System Reports</h1>

    <h2>Available Reports</h2>
    <ul>
        <li><a href="{{ route('admin.reports.previous.month') }}">Total Sales for Previous Month</a></li>
        <li><a href="{{ route('admin.reports.specific.day.form') }}">Total Sales for Specific Day</a></li>
        <li><a href="{{ route('admin.reports.top.customers') }}">Top 5 Customers (Last 3 Months)</a></li>
        <li><a href="{{ route('admin.reports.top.books') }}">Top 10 Selling Books (Last 3 Months)</a></li>
        <li><a href="{{ route('admin.reports.book.orders.form') }}">Total Replenishment Orders for a Book</a></li>
    </ul>

    <br>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>