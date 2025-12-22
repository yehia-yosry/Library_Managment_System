<!DOCTYPE html>
<html>

<head>
    <title>Add New Book</title>
</head>

<body>
    <h1>Add New Book</h1>

    <!-- Display error messages -->
    @if(session('error'))
        <p style="color: red;">{!! session('error') !!}</p>
    @endif

    <!-- Form to add new book -->
    <form method="POST" action="{{ route('admin.books.store') }}">
        @csrf

        <label>ISBN (13 characters):</label><br>
        <input type="text" name="isbn" value="{{ old('isbn') }}" required maxlength="13"><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" value="{{ old('title') }}" required><br><br>

        <label>Publication Year:</label><br>
        <input type="number" name="publication_year" value="{{ old('publication_year') }}" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="{{ old('quantity', 0) }}" required><br><br>

        <label>Threshold (Minimum Stock):</label><br>
        <input type="number" name="threshold" value="{{ old('threshold', 5) }}" required><br><br>

        <label>Category:</label><br>
        <select name="category_id" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->CategoryID }}" {{ old('category_id') == $category->CategoryID ? 'selected' : '' }}>
                    {{ $category->CategoryName }}
                </option>
            @endforeach
        </select><br><br>

        <label>Publisher:</label><br>
        <select name="publisher_id" required>
            <option value="">Select Publisher</option>
            @foreach($publishers as $publisher)
                <option value="{{ $publisher->PublisherID }}" {{ old('publisher_id') == $publisher->PublisherID ? 'selected' : '' }}>
                    {{ $publisher->Name }}
                </option>
            @endforeach
        </select><br><br>

        <label>Authors (Select one or more):</label><br>
        <select name="author_ids[]" multiple required size="10">
            @foreach($authors as $author)
                <option value="{{ $author->AuthorID }}" {{ in_array($author->AuthorID, old('author_ids', [])) ? 'selected' : '' }}>
                    {{ $author->AuthorName }}
                </option>
            @endforeach
        </select><br>
        <small>Hold Ctrl (Windows) or Cmd (Mac) to select multiple authors</small><br><br>

        <button type="submit">Add Book</button>
        <a href="{{ route('admin.dashboard') }}">Cancel</a>
    </form>
</body>

</html>