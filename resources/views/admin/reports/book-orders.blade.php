<!DOCTYPE html>
<html>
<head>
    <title>Book Replenishment Orders Count</title>
</head>
<body>
    <h1>Replenishment Orders for Book</h1>
    
    <p><strong>ISBN:</strong> {{ $isbn }}</p>
    <p><strong>Title:</strong> {{ $book->Title }}</p>
    
    <h2>Total Replenishment Orders Placed: {{ $order_count }}</h2>
    
    <p>This shows how many times the admin has placed orders with publishers to replenish stock for this book.</p>
    
    <br>
    <a href="{{ route('admin.reports.book.orders.form') }}">Check Another Book</a>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>
</html>