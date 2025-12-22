<!DOCTYPE html>
<html>
<head>
    <title>Top 10 Selling Books</title>
</head>
<body>
    <h1>Top 10 Selling Books (Last 3 Months)</h1>
    
    <p><strong>Period:</strong> Since {{ $three_months_ago }}</p>
    
    @if(count($books) > 0)
        <table border="1" cellpadding="10">
            <tr>
                <th>Rank</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Total Copies Sold</th>
            </tr>
            @foreach($books as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book->ISBN }}</td>
                    <td>{{ $book->Title }}</td>
                    <td>{{ $book->total_sold }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No book sales found in the last 3 months.</p>
    @endif
    
    <br>
    <a href="{{ route('admin.reports.menu') }}">Back to Reports</a>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>
</html>
