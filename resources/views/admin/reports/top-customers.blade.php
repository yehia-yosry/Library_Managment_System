<!DOCTYPE html>
<html>

<head>
    <title>Top 5 Customers</title>
</head>

<body>
    <h1>Top 5 Customers (Last 3 Months)</h1>

    <p><strong>Period:</strong> Since {{ $three_months_ago }}</p>

    @if(count($customers) > 0)
        <table border="1" cellpadding="10">
            <tr>
                <th>Rank</th>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Total Spent</th>
            </tr>
            @foreach($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->CustomerID }}</td>
                    <td>{{ $customer->FirstName }} {{ $customer->LastName }}</td>
                    <td>{{ $customer->Email }}</td>
                    <td>${{ number_format($customer->total_spent, 2) }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No customer purchases found in the last 3 months.</p>
    @endif

    <br>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>