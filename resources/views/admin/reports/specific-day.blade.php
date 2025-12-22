<!DOCTYPE html>
<html>

<head>
    <title>Sales for Specific Day</title>
</head>

<body>
    <h1>Total Sales for {{ $date }}</h1>

    <h2>Total Sales: ${{ number_format($total_sales, 2) }}</h2>

    <br>
    <a href="{{ route('admin.reports.specific.day.form') }}">Check Another Date</a>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>