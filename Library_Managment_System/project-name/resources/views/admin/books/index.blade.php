@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Books</h1>
        <a href="{{ route('admin.books.create') }}" class="btn btn-success">Create Book</a>
    </div>

    <table class="table mt-3">
        <thead><tr><th>ISBN</th><th>Title</th><th>Category</th><th>Price</th><th>Stock</th><th></th></tr></thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->ISBN }}</td>
                <td><a href="{{ route('admin.books.show', $book->ISBN) }}">{{ $book->Title }}</a></td>
                <td>{{ $book->category->CategoryName ?? '-' }}</td>
                <td>${{ number_format($book->Price,2) }}</td>
                <td>{{ $book->Quantity }}</td>
                <td>
                    <a href="{{ route('admin.books.edit', $book->ISBN) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="post" action="{{ route('admin.books.destroy', $book->ISBN) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div>{{ $books->links() }}</div>
@endsection