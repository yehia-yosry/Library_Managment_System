<!DOCTYPE html>
<html>

<head>
    <title>Search Books</title>
</head>

<body>
    <h1>Search for Books</h1>

    <!-- Display error messages -->
    @if(isset($error))
        <p style="color: red;">{{ $error }}</p>
    @endif

    <!-- Search form -->
    <form method="GET" action="{{ route('admin.books.search.general') }}">
        <label>Search By:</label><br>
        <select name="search_type" required>
            <option value="">Select Search Type</option>
            <option value="isbn" {{ ($search_type ?? '') == 'isbn' ? 'selected' : '' }}>ISBN</option>
            <option value="title" {{ ($search_type ?? '') == 'title' ? 'selected' : '' }}>Title</option>
            <option value="category" {{ ($search_type ?? '') == 'category' ? 'selected' : '' }}>Category</option>
            <option value="author" {{ ($search_type ?? '') == 'author' ? 'selected' : '' }}>Author</option>
            <option value="publisher" {{ ($search_type ?? '') == 'publisher' ? 'selected' : '' }}>Publisher</option>
        </select><br><br>

        <label>Search Term:</label><br>
        <input type="text" name="search_term" value="{{ $search_term ?? '' }}" required placeholder="Enter search term">
        <button type="submit">Search</button>
    </form>

    <br>

    <!-- Display search results -->
    @if(isset($books) && count($books) > 0)
        <h2>Search Results ({{ count($books) }} book(s) found)</h2>
        <table border="1" cellpadding="10">
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Authors</th>
                <th>Publisher</th>
                <th>Publication Year</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity Available</th>
            </tr>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->ISBN }}</td>
                    <td>{{ $book->Title }}</td>
                    <td>{{ $book->authors }}</td>
                    <td>{{ $book->PublisherName }}</td>
                    <td>{{ $book->PublicationYear }}</td>
                    <td>{{ $book->CategoryName }}</td>
                    <td>${{ number_format($book->Price, 2) }}</td>
                    <td>
                        @if($book->Quantity > 0)
                            <span style="color: green;">{{ $book->Quantity }} in stock</span>
                        @else
                            <span style="color: red;">Out of stock</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @elseif(isset($search_term) && !empty($search_term))
        <p>No books found matching your search criteria.</p>
    @endif

    <br>
    <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
</body>

</html>