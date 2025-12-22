<!DOCTYPE html>
<html>

<head>
    <title>Edit Book</title>
</head>

<body>
    <h1>Edit Book: {{ $book->Title }}</h1>

    <!-- Display error messages -->
    @if(session('error'))
        <p style="color: red;">{!! session('error') !!}</p>
    @endif

    <!-- Form to update book -->
    <form method="POST" action="{{ route('admin.books.update', $book->ISBN) }}">
        @csrf

        <p><strong>ISBN:</strong> {{ $book->ISBN }} (Cannot be changed)</p>

        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title', $book->Title) }}"><br><br>

        <label>Publication Year:</label><br>
        <input type="number" name="publication_year"
            value="{{ old('publication_year', $book->PublicationYear) }}"><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price', $book->Price) }}"><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="{{ old('quantity', $book->Quantity) }}"><br><br>

        <label>Threshold (Minimum Stock):</label><br>
        <input type="number" name="threshold" value="{{ old('threshold', $book->Threshold) }}"><br><br>

        <label>Category:</label><br>
        <select name="category_id">
            @foreach($categories as $category)
                <option value="{{ $category->CategoryID }}" {{ old('category_id', $book->CategoryID) == $category->CategoryID ? 'selected' : '' }}>
                    {{ $category->CategoryName }}
                </option>
            @endforeach
        </select><br><br>

        <label>Publisher:</label><br>
        <select name="publisher_id">
            @foreach($publishers as $publisher)
                <option value="{{ $publisher->PublisherID }}" {{ old('publisher_id', $book->PublisherID) == $publisher->PublisherID ? 'selected' : '' }}>
                    {{ $publisher->Name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Authors (Select one or more):</label><br>
        <select name="author_ids[]" multiple size="10">
            @foreach($authors as $author)
                <option value="{{ $author->AuthorID }}" {{ in_array($author->AuthorID, old('author_ids', $current_author_ids)) ? 'selected' : '' }}>
                    {{ $author->AuthorName }}
                </option>
            @endforeach
        </select><br>
        <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple authors</small><br><br>

        <button type="submit">Update Book</button>
        <a href="{{ route('admin.books.search') }}">Cancel</a>
    </form>
</body>

</html>