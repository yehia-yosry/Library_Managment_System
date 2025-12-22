<!DOCTYPE html>
<html>

<head>
    <title>Previous Month Sales</title>
</head>

<body>
    <h1>Total Sales for Previous Month</h1>

    <p><strong>Period:</strong> {{ $first_day_previous_month }} to {{ $last_day_previous_month }}</p>

    <h2>Total Sales: ${{ number_format($total_sales, 2) }}</h2>

    <br>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>