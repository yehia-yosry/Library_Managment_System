<!DOCTYPE html>
<html>

<head>
    <title>Sales for Specific Day</title>
</head>

<body>
    <h1>Total Sales for Specific Day</h1>

    <!-- Display error messages -->
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Form to select date -->
    <form method="POST" action="{{ route('admin.reports.specific.day') }}">
        @csrf

        <label>Select Date:</label><br>
        <input type="date" name="date" required>
        <button type="submit">Get Sales Report</button>
    </form>

    <br>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>