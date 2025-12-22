<!DOCTYPE html>
<html>
<head>
    <title>Book Replenishment Orders Count</title>
</head>
<body>
    <h1>Total Number of Replenishment Orders for a Book</h1>
    
    <!-- Display error messages -->
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    
    <!-- Form to enter ISBN -->
    <form method="POST" action="{{ route('admin.reports.book.orders') }}">
        @csrf
        
        <label>Enter Book ISBN:</label><br>
        <input type="text" name="isbn" required maxlength="13" placeholder="Enter 13-digit ISBN">
        <button type="submit">Get Order Count</button>
    </form>
    
    <br>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>
</html>
