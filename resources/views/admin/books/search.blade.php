<!DOCTYPE html>
<html>

<head>
    <title>Search Books to Edit</title>
</head>

<body>
    <h1>Search Books to Edit</h1>

    <!-- Display success/error messages -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Search form -->
    <form method="GET" action="{{ route('admin.books.search') }}">
        <label>Search by ISBN or Title:</label><br>
        <input type="text" name="search" value="{{ $search_term ?? '' }}" placeholder="Enter ISBN or Title">
        <button type="submit">Search</button>
    </form>

    <br>

    <!-- Display search results -->
    @if(isset($books) && count($books) > 0)
        <h2>Search Results</h2>
        <table border="1" cellpadding="10">
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Publication Year</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Threshold</th>
                <th>Category</th>
                <th>Publisher</th>
                <th>Action</th>
            </tr>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->ISBN }}</td>
                    <td>{{ $book->Title }}</td>
                    <td>{{ $book->PublicationYear }}</td>
                    <td>${{ number_format($book->Price, 2) }}</td>
                    <td>{{ $book->Quantity }}</td>
                    <td>{{ $book->Threshold }}</td>
                    <td>{{ $book->CategoryName }}</td>
                    <td>{{ $book->PublisherName }}</td>
                    <td>
                        <a href="{{ route('admin.books.edit', $book->ISBN) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @elseif(isset($search_term) && !empty($search_term))
        <p>No books found.</p>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>